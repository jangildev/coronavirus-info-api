var quarantine = 0;
var overwatch = 0;
var infected = 0;
var deaths = 0;
var recovered = 0;
var stats;

var curr_info_height;
var curr_m_c_height;

var token = "eyJsb2dpbiI6ImNvdmlkaW5mbyIsInBhc3N3b3JkIjoiOWUzOGU4ZDY4ODc0M2UwZDA3ZDY2OWExZmNiY2QzNWIiLCJwb3N0IjowfQ==";
var api_url = "http://www.coronavirusinfo.cba.pl";

$(document).ready(()=>{
    $("#info").width(window.innerWidth - $("#map").width() - 200);
    curr_info_height = $("#info").height();
    curr_m_c_height = $("#map_content").innerHeight();
    $.ajax({
        type: "GET",
        url: api_url + "/api/stats",
        headers : {
            "Authorization":token
        },
        success: function (response) {
            stats = response;
        }
    });

    $.ajax({
        type: "GET",
        url: api_url + "/api/poland",
        headers : {
            "Authorization":token
        },
        success: function (response) {
            quarantine = parseInt(response.quarantine);
            overwatch = parseInt(response.overwatch);
            infected = parseInt(response.infected);
            deaths = parseInt(response.deaths);
            recovered = parseInt(response.recovered);
            polska();
        }
    });

});

function polska() 
{
    $("#info").html("<h1>Polska</h1> <h3>Poddanych kwarantannie : <b>"+quarantine+"</b></h3> <h3>Pod nadzorem epidemiologicznym : <b>"+overwatch+"</b></h3> <h3> Chorzy : <b>"+infected+"</b></h3><h3> Umarło : <b>"+deaths+"</b></h3><h3> Wyzdrowiało : <b>"+recovered+"</b></h3>" );
}

function setStateById(id) {
    var request = new XMLHttpRequest();

    request.open("GET" , api_url + "/api/state/" + id);

    request.setRequestHeader("Authorization",token);

    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           setState(JSON.parse(request.responseText));
        }
    };

    request.send();
}

function setState(s)
{
    var content = "<h1>" + s.state + "</h1> <h3> Poddanych kwarantannie : <b>"+ s.quarantine +"</b></h3> <h3> Pod nadzorem epidemiologicznym : <b>"+ s.overwatch +"</b></h3>";

    content += "<div id='cities'>";

    s.cities.forEach(element => {

        content += "<div id='city'><h2>" + element.name+ "</h2><h3> Chorzy : <b>" + stats[element.id - 1].infected + "</b></h3><h3> Umarło : " + stats[element.id - 1].deaths + "</b></h3> <h3> Wyzdrowiało : <b>" + stats[element.id - 1].recovered + "</b></h3></div>";
    });

    content += "</div>";

    $("#info").html(content);


    if($("#cities").innerHeight() > curr_info_height - 150)
    {
        $("#footer").css("margin-top" , ($("#cities").height() - (curr_info_height-150)) + 50);
        $("#info").height($("#cities").height()+150);
        $("#map_content").height($("#cities").height());
    }
    else
    {
        $("#footer").css("margin-top" , "0");
        $("#info").height(curr_info_height);
        $("#map_content").height(curr_m_c_height);
    }
}

$(".tstate").mouseover(function () { 
    var id = $(this).attr("alt");
    setStateById(id);
});

$(".tstate").mouseleave(()=>{
    polska();
    $("#footer").css("margin-top" , "0");
    $("#info").height(curr_info_height);
    $("#map_content").height(curr_m_c_height);
});


$("#map").mouseleave(()=>{
    polska();
    $("#footer").css("margin-top" , "0");
    $("#info").height(curr_info_height);
    $("#map_content").height(curr_m_c_height);
});

$(window).resize(()=>{
    $("#info").width(window.innerWidth - $("#map").width() - 200);
});