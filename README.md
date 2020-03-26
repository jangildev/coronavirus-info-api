## Welcome to Coronavirus Info API

We provide data on the development of the COVID-19 virus in Poland. Using this API is open and completely free for everyone. Data is refreshed daily and comes from official public information. All names and text data are returned in Polish with Polish diacretic characters.

### Token

Coronavirus Info API uses API KEY Authorization which means that you have to add header with token to your request.
```
'Authorization: your_token'
```

You can get a token at <a href="http://coronavirusinfo.cba.pl/api/token">http://coronavirusinfo.cba.pl/api/token</a>. 

Simple AJAX example :
```javascript
    $.ajax({
        type: "GET",
        url: "http://www.coronavirusinfo.cba.pl/api/poland",
        headers : {
            "Authorization":"your_token"
        },
        success: function (response) {
           ...
        }
    });
```

### Basic operations

To receive list of all provinces in Poland and their statistitics :

```
http://www.coronavirusinfo.cba.pl/api/state
```

Response :

```javascript
[
    {
        "id": "3",
        "name": "Dolnośląskie",
        "quarantine": "4114",
        "overwatch": "2949"
    },
    {
        "id": "4",
        "name": "Kujawsko-pomorskie",
        "quarantine": "5501",
        "overwatch": "1763"
    },
    ...
]    
```
To get data about specific province :

```
http://www.coronavirusinfo.cba.pl/api/state/5
```

Response :

```javascript
{
    "state": "Lubelskie",
    "quarantine": "5019",
    "overwatch": "5656",
    "cities": [
        {
            "id": "20",
            "name": "Bełżyce"
        },
        {
            "id": "21",
            "name": "Lublin"
        }
    ]
}		

```
To receive list of all cities in Poland with coronavirus cases and their statistitics :

```
http://www.coronavirusinfo.cba.pl/api/city
```

Response :

```javascript
[
    {
        "id": "1",
        "name": "Szczecin",
        "state_id": "18"
    },
    {
        "id": "2",
        "name": "Gdańsk",
        "state_id": "13"
    },
    ...
]    
```
To get data about specific city :

```
http://www.coronavirusinfo.cba.pl/api/city/5
```

Response :

```javascript
{
        "id": "5",
        "name": "Warszawa",
        "infected": "251",
        "deaths": "1",
        "recovered": "13"
}	

```

To get general statistics :
```
http://www.coronavirusinfo.cba.pl/api/poland
```
Response : 

```
{
    "infected": "1052",
    "deaths": "14",
    "recovered": "13",
    "quarantine": "54174",
    "overwatch": "53044"
}		
```
Sample website using coronavirus-info-api <a href="http://www.coronavirusinfo.cba.pl">http://www.coronavirusinfo.cba.pl</a>
