Работа с картами <span id="card"></span>
============================

Получение данных по зарегистрированным картам. <span id="card-data"></span>
----------------------------

Для получения данных по картам зарегистриранным за пользователем необходимо использовать следующие виды запросов.

### Переменные <span id="card-var"></span>

Имя        |  Значение
-----------|----------------------------------------------------
hash       | Код авторизации обязательная переменная для доступа.
expand     | Расширяемые поля может принимать только limits
page       | Номер страницы
per-page   | Количество записей на странице


### Выходные данные <span id="card-outdata"></span>

`cards` - массив выгружаемых карт

Индекс                  | Значение
------------------------|---------------------
ID_CARD                 | Идентификатор карты
ISSUE_DATE              | Дата выдачи
ID_CLIENT               | Идентификатор клиента
CARD_NUMBER             | Графический номер карты
HOLDER_CARD             | Держатель карты
DATE_LAST_SERVICE       | Дата последней операции
ID_CONDITION            | Идентификатор состояния карты (1 - в работе, 5 - в ЧС)
DESCRIPTION_CONDITION   | Описание состояний карты

`limits` - массив кошельков закрепленных за картой

Индекс      | Значение
------------|------------------
AMOUNT      | Размер лимита
UNIT        | Еденица изерения (currency - валюта, liters - литры)
TYPE        | Тип лимита (daily - дневной, monthly - месячный)
CODE        | Массив кодов кошельков
FUEL        | Массив названий кошельков

> NODE: `CODE` и `FUEL` принимаю еденичное значение для индивидуальных лимитов или массив для общих лимитов

Примеры запроса <span id="card-quest"></span>
----------------------------


~~~html
http://rest.neftika-card.ru/v02/cards/?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=
http://rest.neftika-card.ru/v02/cards/?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&expand=limits
http://rest.neftika-card.ru/v02/cards/?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&page=2&per-page=20
http://rest.neftika-card.ru/v02/cards/?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&page=2&per-page=20&expand=limits&page=2&per-page=3
~~~

Получение списка карт с базовой разбивков на страницы (по умолчанию 20 карт).

~~~http
http://rest.neftika-card.ru/v02/cards/?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=
~~~

~~~json
{
    "cards": [
        {
            "ID_CARD": 21823,
            "ISSUE_DATE": "22.06.2016",
            "ID_CLIENT": 823,
            "CARD_NUMBER": 648034820,
            "HOLDER_CARD": "Титов С.Г.",
            "DATE_LAST_SERVICE": "30.06.2014",
            "ID_CONDITION": 5,
            "DESCRIPTION_CONDITION": "Заблокирована"
        },
        {
            "ID_CARD": 20719,
            "ISSUE_DATE": "22.06.2016",
            "ID_CLIENT": 823,
            "CARD_NUMBER": 648033716,
            "HOLDER_CARD": " ",
            "DATE_LAST_SERVICE": "09.05.2016",
            "ID_CONDITION": 5,
            "DESCRIPTION_CONDITION": "Заблокирована"
        },
     ],
    "_links": {
        "self": {
            "href": "http://rest.neftika-card.ru/v02/cards/?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY%3D&page=1"
        },
        "next": {
            "href": "http://rest.neftika-card.ru/v02/cards/?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY%3D&page=2"
        },
        "last": {
            "href": "http://rest.neftika-card.ru/v02/cards/?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY%3D&page=101"
        }
    },
    "_meta": {
        "totalCount": 2008,
        "pageCount": 101,
        "currentPage": 1,
        "perPage": 20
    }
}
~~~

Получние расширенных данных по картам с кошелками. <span id="card-data-expand"></span>
-----------------------


### Запрос

~~~http
http://rest.neftika-card.ru/v02/cards/?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&expand=limits
~~~

### Пример вывода

~~~json
{
    "cards": [
        {
            "ID_CARD": 21823,
            "ISSUE_DATE": "22.06.2016",
            "ID_CLIENT": 823,
            "CARD_NUMBER": 648034820,
            "HOLDER_CARD": "Титов С.Г.",
            "DATE_LAST_SERVICE": "30.06.2014",
            "ID_CONDITION": 5,
            "DESCRIPTION_CONDITION": "Заблокирована",
            "limits": [
                {
                    "AMOUNT": "10000",
                    "UNIT": "currency",
                    "TYPE": "monthly",
                    "CODE": "1",
                    "FUEL": "Рубли"
                },
                {
                    "AMOUNT": "0",
                    "UNIT": "liters",
                    "TYPE": "monthly",
                    "CODE": "14,13",
                    "FUEL": "Евро 95/4,Евро 92/4"
                }
            ]
        },
        {
            "ID_CARD": 20719,
            "ISSUE_DATE": "22.06.2016",
            "ID_CLIENT": 823,
            "CARD_NUMBER": 648033716,
            "HOLDER_CARD": " ",
            "DATE_LAST_SERVICE": "09.05.2016",
            "ID_CONDITION": 5,
            "DESCRIPTION_CONDITION": "Заблокирована",
            "limits": [
                {
                    "AMOUNT": "100",
                    "UNIT": "liters",
                    "TYPE": "daily",
                    "CODE": "13,4",
                    "FUEL": "Евро 92/4,Аи-92"
                }
            ]
        },
    ],
    "_links": {
        "self": {
            "href": "http://rest.neftika-card.ru/v02/cards/?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY%3D&expand=limits&page=1"
        },
        "next": {
            "href": "http://rest.neftika-card.ru/v02/cards/?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY%3D&expand=limits&page=2"
        },
        "last": {
            "href": "http://rest.neftika-card.ru/v02/cards/?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY%3D&expand=limits&page=101"
        }
    },
    "_meta": {
        "totalCount": 2008,
        "pageCount": 101,
        "currentPage": 1,
        "perPage": 20
    }
}
~~~

Запрос для отдельной карты <span id="card-data-carent"></span>
------------------------


Для получение детальной информации по отдельной карте используются запросы следующего вида.

### Запрос информации по карте без детализации

~~~http
http://rest.neftika-card.ru/v02/cards/648034820?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=
~~~

~~~json
{
    "ID_CARD": 21823,
    "ISSUE_DATE": "22.06.2016",
    "ID_CLIENT": 823,
    "CARD_NUMBER": 648034820,
    "HOLDER_CARD": "Титов С.Г.",
    "DATE_LAST_SERVICE": "30.06.2014",
    "ID_CONDITION": 5,
    "DESCRIPTION_CONDITION": "Заблокирована"
}
~~~

### ### Запрос информации по карте с детализаций

~~~http
http://rest.neftika-card.ru/v02/cards/648034820?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&expand=limits
~~~

### Пример вывода

~~~json
{
    "ID_CARD": 21823,
    "ISSUE_DATE": "22.06.2016",
    "ID_CLIENT": 823,
    "CARD_NUMBER": 648034820,
    "HOLDER_CARD": "Титов С.Г.",
    "DATE_LAST_SERVICE": "30.06.2014",
    "ID_CONDITION": 5,
    "DESCRIPTION_CONDITION": "Заблокирована",
    "limits": [
        {
            "AMOUNT": "10000",
            "UNIT": "currency",
            "TYPE": "monthly",
            "CODE": "1",
            "FUEL": "Рубли"
        },
        {
            "AMOUNT": "0",
            "UNIT": "liters",
            "TYPE": "monthly",
            "CODE": "14,13",
            "FUEL": "Евро 95/4,Евро 92/4"
        }
    ]
}
~~~

Обновление статуса карты <span id="card-update"></span>
-------------------------

> Note: Обновление статуса карты производится методом `PUT`. Формат закроса должен включат переменную `status` которая может принимать следующие значения `status=1` карат в работе, `status=0` карта заблокирована.

Примеры запросов и ответы

~~~http
http://rest.neftika-card.ru/v02/cards/648034820?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&status=0
~~~

~~~json
{
    "result": 1,
    "card": {
             "ID_CARD": 21823,
             "ISSUE_DATE": "22.06.2016",
             "ID_CLIENT": 823,
             "CARD_NUMBER": 648034820,
             "HOLDER_CARD": "Титов С.Г.",
             "DATE_LAST_SERVICE": "30.06.2014",
             "ID_CONDITION": 5,
             "DESCRIPTION_CONDITION": "Заблокирована"
    }
}
~~~

~~~http
http://rest.neftika-card.ru/v02/cards/648034820?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&status=1
~~~

~~~json
{
    "result": 1,
    "card": {
             "ID_CARD": 21823,
             "ISSUE_DATE": "22.06.2016",
             "ID_CLIENT": 823,
             "CARD_NUMBER": 648034820,
             "HOLDER_CARD": "Титов С.Г.",
             "DATE_LAST_SERVICE": "30.06.2014",
             "ID_CONDITION": 5,
             "DESCRIPTION_CONDITION": "В работе"
    }
}
~~~

В случае если обращение идет к карте с незарегистрированным номером выдается следующий результат

~~~http
http://rest.neftika-card.ru/v02/cards/648099999?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&status=1
~~~

~~~json
{
    "result": 0,
    "card": null
}
~~~
