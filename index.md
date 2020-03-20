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


For more details see [GitHub Flavored Markdown](https://guides.github.com/features/mastering-markdown/).

### Jekyll Themes

Your Pages site will use the layout and styles from the Jekyll theme you have selected in your [repository settings](https://github.com/jangildev/coronavirus-info-api/settings). The name of this theme is saved in the Jekyll `_config.yml` configuration file.

### Support or Contact

Having trouble with Pages? Check out our [documentation](https://help.github.com/categories/github-pages-basics/) or [contact support](https://github.com/contact) and we’ll help you sort it out.
