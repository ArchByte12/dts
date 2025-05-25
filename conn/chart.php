<?php
require 'connection.php';
session_start();
ob_start(); // Start output buffering

$database = $client->selectDatabase('dts_db');
$collection = $database->selectCollection('documents');

if (isset($_POST['history'])) {
    $document_origin = $_POST['document_origination'];

    // Query to get distinct month-year values in MMM-YYYY format
    $pipeline = [
        [
            '$match' => [
                '$or' => [
                    ['document_origin' => $document_origin],
                    ['document_destination' => $document_origin]
                ]
            ]
        ],
        [
            '$project' => [
                'monthYear' => [
                    '$dateToString' => ['format' => '%b-%Y', 'date' => ['$toDate' => '$created_date']]
                ]
            ]
        ],
        [
            '$group' => [
                '_id' => '$monthYear'
            ]
        ],
        [
            '$sort' => ['_id' => -1]
        ]
    ];

    $cursor = $collection->aggregate($pipeline);

    $monthYears = [];
    foreach ($cursor as $document) {
        $monthYears[] = $document['_id'];
    }

    // Output the distinct month-year values
    header('Content-Type: application/json');
    echo json_encode($monthYears);
}

// get all documents count by type (incoming, outgoing, terminal)
if (isset($_POST['getAllCount'])) {
    $document_origin = $_POST['document_origin'];

    // Adjust filter logic
    $matchFilter = ($document_origin === 'Records Section') ? [] : [
        'document_origin' => $document_origin
    ];

    // Query to count documents by type using flags
    $pipeline = [
        [
            '$match' => $matchFilter
        ],
        [
            '$group' => [
                '_id' => null,
                'outgoingCount' => ['$sum' => ['$toInt' => '$outgoing_flag']],
                'terminalDocsCount' => ['$sum' => ['$toInt' => '$terminal_flag']]
            ]
        ]
    ];

    $cursor = $collection->aggregate($pipeline);

    $counts = [
        'outgoingCount' => 0,
        'terminalDocsCount' => 0
    ];

    foreach ($cursor as $document) {
        $counts['outgoingCount'] = $document['outgoingCount'] ?? 0;
        $counts['terminalDocsCount'] = $document['terminalDocsCount'] ?? 0;
    }

    // Output the counts
    header('Content-Type: application/json');
    echo json_encode($counts);
}

// get all documents count by type (incoming)
if (isset($_POST['getAllIncomingCount'])) {
    $document_origin = $_POST['document_origin'];

    // Adjust filter logic
    $matchFilter = ($document_origin === 'Records Section') ? [] : [
        'document_destination' => $document_origin
    ];

    // Query to count documents by type using flags
    $pipeline = [
        [
            '$match' => $matchFilter
        ],
        [
            '$group' => [
                '_id' => null,
                'incomingCount' => ['$sum' => ['$toInt' => '$incoming_flag']],
            ]
        ]
    ];

    $cursor = $collection->aggregate($pipeline);

    $counts = [
        'incomingCount' => 0,
    ];

    foreach ($cursor as $document) {
        $counts['incomingCount'] = $document['incomingCount'] ?? 0;
    }

    // Output the counts
    header('Content-Type: application/json');
    echo json_encode($counts);
}

if (isset($_POST['getCombinedCount'])) {
    $monthYear = $_POST['monthYear'];
    $document_origin = $_POST['document_origination'];

    // Convert month-year to date range
    $startDate = new MongoDB\BSON\UTCDateTime(strtotime("first day of $monthYear 00:00:00") * 1000);
    $endDate = new MongoDB\BSON\UTCDateTime(strtotime("last day of $monthYear 23:59:59") * 1000);

    // Adjust filter logic for outgoing and terminal counts
    $matchFilterOutgoing = ($document_origin === 'Records Section') ? [
        'created_date_parsed' => [
            '$gte' => $startDate,
            '$lte' => $endDate
        ]
    ] : [
        'created_date_parsed' => [
            '$gte' => $startDate,
            '$lte' => $endDate
        ],
        'document_origin' => $document_origin
    ];

    // Adjust filter logic for incoming count
    $matchFilterIncoming = ($document_origin === 'Records Section') ? [
        'created_date_parsed' => [
            '$gte' => $startDate,
            '$lte' => $endDate
        ]
    ] : [
        'created_date_parsed' => [
            '$gte' => $startDate,
            '$lte' => $endDate
        ],
        'document_destination' => $document_origin
    ];

    // Query for outgoing and terminal counts
    $pipelineOutgoing = [
        [
            '$addFields' => [
                'created_date_parsed' => [
                    '$dateFromString' => [
                        'dateString' => '$created_date',
                        'format' => '%Y-%m-%d %H:%M:%S'
                    ]
                ]
            ]
        ],
        [
            '$match' => $matchFilterOutgoing
        ],
        [
            '$group' => [
                '_id' => null,
                'outgoingCount' => ['$sum' => ['$toInt' => '$outgoing_flag']],
                'terminalDocsCount' => ['$sum' => ['$toInt' => '$terminal_flag']]
            ]
        ]
    ];

    // Query for incoming count
    $pipelineIncoming = [
        [
            '$addFields' => [
                'created_date_parsed' => [
                    '$dateFromString' => [
                        'dateString' => '$created_date',
                        'format' => '%Y-%m-%d %H:%M:%S'
                    ]
                ]
            ]
        ],
        [
            '$match' => $matchFilterIncoming
        ],
        [
            '$group' => [
                '_id' => null,
                'incomingCount' => ['$sum' => ['$toInt' => '$incoming_flag']]
            ]
        ]
    ];

    // Execute both pipelines
    $outgoingCursor = $collection->aggregate($pipelineOutgoing);
    $incomingCursor = $collection->aggregate($pipelineIncoming);

    // Initialize counts
    $counts = [
        'incomingCount' => 0,
        'outgoingCount' => 0,
        'terminalDocsCount' => 0
    ];

    // Process outgoing and terminal counts
    foreach ($outgoingCursor as $document) {
        $counts['outgoingCount'] = $document['outgoingCount'] ?? 0;
        $counts['terminalDocsCount'] = $document['terminalDocsCount'] ?? 0;
    }

    // Process incoming count
    foreach ($incomingCursor as $document) {
        $counts['incomingCount'] = $document['incomingCount'] ?? 0;
    }

    // Output the combined counts
    header('Content-Type: application/json');
    echo json_encode($counts);
}

if (isset($_POST['getAllCombineCounts'])) {
    $document_origin = $_POST['document_origin'];

    // Adjust filter logic for outgoing and terminal counts
    $matchFilterOutgoing = ($document_origin === 'Records Section') ? null : [
        'document_origin' => $document_origin
    ];

    // Adjust filter logic for incoming count
    $matchFilterIncoming = ($document_origin === 'Records Section') ? null : [
        'document_destination' => $document_origin
    ];

    // Query for outgoing and terminal counts
    $pipelineOutgoing = [];
    if ($matchFilterOutgoing) {
        $pipelineOutgoing[] = ['$match' => $matchFilterOutgoing];
    }
    $pipelineOutgoing[] = [
        '$group' => [
            '_id' => null,
            'outgoingCount' => ['$sum' => ['$toInt' => '$outgoing_flag']],
            'terminalDocsCount' => ['$sum' => ['$toInt' => '$terminal_flag']]
        ]
    ];

    // Query for incoming count
    $pipelineIncoming = [];
    if ($matchFilterIncoming) {
        $pipelineIncoming[] = ['$match' => $matchFilterIncoming];
    }
    $pipelineIncoming[] = [
        '$group' => [
            '_id' => null,
            'incomingCount' => ['$sum' => ['$toInt' => '$incoming_flag']]
        ]
    ];

    // Execute both pipelines
    $outgoingCursor = $collection->aggregate($pipelineOutgoing);
    $incomingCursor = $collection->aggregate($pipelineIncoming);

    // Initialize counts
    $counts = [
        'incomingCount' => 0,
        'outgoingCount' => 0,
        'terminalDocsCount' => 0
    ];

    // Process outgoing and terminal counts
    foreach ($outgoingCursor as $document) {
        $counts['outgoingCount'] = $document['outgoingCount'] ?? 0;
        $counts['terminalDocsCount'] = $document['terminalDocsCount'] ?? 0;
    }

    // Process incoming count
    foreach ($incomingCursor as $document) {
        $counts['incomingCount'] = $document['incomingCount'] ?? 0;
    }

    // Output the combined counts
    header('Content-Type: application/json');
    echo json_encode($counts);
}

if (isset($_POST['getPendingCount'])) {
    $document_origin = $_SESSION['office'];

    // Adjust filter logic
    $matchFilter = ($document_origin === 'Records Section') ? [
        'status' => 'Pending', // Return all documents with "Pending" status
        'incoming_flag' => 1
    ] : [
        'document_destination' => $document_origin,
        'status' => 'Pending',
        'incoming_flag' => 1
    ];

    $pipeline = [
        [
            '$match' => $matchFilter
        ],
        [
            '$group' => [
                '_id' => '$status',
                'count' => ['$sum' => 1]
            ]
        ],
        [
            '$project' => [
                'status' => '$_id',
                'count' => 1,
                '_id' => 0
            ]
        ]
    ];

    // Debugging: Log the pipeline for verification
    error_log("Pipeline: " . json_encode($pipeline));

    $cursor = $collection->aggregate($pipeline);

    $counts = [
        'pendingCount' => 0
    ];

    foreach ($cursor as $document) {
        // Debugging: Log each document in the cursor
        error_log("Aggregated Document: " . json_encode($document));

        if (isset($document['status']) && $document['status'] === 'Pending') {
            $counts['pendingCount'] = $document['count'];
        }
    }

    // Debugging: Log the final counts
    error_log("Final Counts: " . json_encode($counts));

    // Clear any previous output and send JSON response
    ob_end_clean();
    header('Content-Type: application/json');
    echo json_encode($counts);
    exit;
}
?>