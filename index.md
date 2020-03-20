## Welcome to Coronavirus Info API

We provide data on the development of the COVID-19 virus in Poland. Using this API is open and completely free for everyone. Data is refreshed daily and comes from official public information. All names and text data are returned in Polish with Polish diacretic characters.

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
        "quarantine": "1125",
        "overwatch": "0"
    },
    {
        "id": "4",
        "name": "Kujawsko-pomorskie",
        "quarantine": "644",
        "overwatch": "0"
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
    "quarantine": "2603",
    "overwatch": "0",
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
        "infected": "18",
        "deaths": "0",
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
    "infected": "108",
    "deaths": "3",
    "recovered": "13",
    "quarantine": "17642",
    "overwatch": "0"
}		
```
Sample website using coronavirus-info-api http://www.coronavirus.cba.pl

### TODO
There will be some tocket authentication if necessery.
