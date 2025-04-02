$(document).ready(function () {
    // localStorage
    var $data = JSON.parse(localStorage.getItem('loginDetails'));
    // get and set from localStorage
    var $username = $data.username;
    var $fullname = $data.fullname;
    var $office = $data.office;
    var $position = $data.position;

    $('#username').text($username);
    $('#fullname').text($fullname);
    $('#office').text($office);
    $('#position').text($position);
});