Работа с картами <span id="card"></span>
============================

Получение данных по зарегистрированным картам. <span id="card-data"></span>
----------------------------

Для получения данных по картам зарегистриранным за пользователем необходимо использовать следующие виды запросов.

### Переменные <span id="card-var"></span>

Имя        |  Значение
-----------|----------------------------------------------------
hash       | Код авторизации обязательная переменная для доступа.
expand     | Расширяемые поля может принимать только purses
page       | Номер страницы
per-page   | Количество записей на странице


### Выходные данные <span id="card-outdata"></span>

`cards` - массив выгружаемых карт

Индекс                 | Значение
-----------------------|---------------------
ID_CARD                | Идентификатор карты
CARD_NUMBER            | Графический номер карты
ID_CONDITION           | Идентификатор состояния карты (1 - в работе, 5 - в ЧС)
DESCRIPTION_CONDITION  | Описание состояний карты
purses                 | массив кошельков закрепленных за картой


`purses` - массив кошельков закрепленных за картой

Индекс                 | Значение
-----------------------|------------------
ID_SERVICES            | Идентификатор услуги
SERVICES_DESCRIPTION   | Описание услуги
LIMIT_PURSE            | Лимит кошелька
MONTHLY_LIMIT          | Признак лимита (0 - Суточный лимит, 1 - Месячный лимит)
INDIVIDUAL_LIMIT       | Признак индивидуального лимита. (0 - Общий лимит, 1 - Индивидуальный лимит)
ID_CARD                | Идентификатор карты
CARD_NUMBER            | Графический номер карты
ID_CONDITION           | Идентификатор состояния карты (1 - в работе, 5 - в ЧС)
DESCRIPTION_CONDITION  | Описание состояний карты

Примеры запроса <span id="card-quest"></span>
----------------------------


~~~html
http://rest.neftika-card.ru/v01/cards?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=
http://rest.neftika-card.ru/v01/cards?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&expand=purses
http://rest.neftika-card.ru/v01/cards?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&page=2&per-page=20
http://rest.neftika-card.ru/v01/cards?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&page=2&per-page=20&expand=purses&page=2&per-page=3
~~~

Получение списка карт с базовой разбивков на страницы (по умолчанию 20 карт).

~~~http
http://rest.neftika-card.ru/v01/cards?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=
~~~

~~~json
{
    "cards": [
        {
            "ID_CARD": 21823,
            "CARD_NUMBER": 648034820,
            "ID_CONDITION": 5,
            "DESCRIPTION_CONDITION": "Заблокирована"
        },
        {
            "ID_CARD": 20719,
            "CARD_NUMBER": 648033716,
            "ID_CONDITION": 5,
            "DESCRIPTION_CONDITION": "Заблокирована"
        },
      ],
    "_links": {
        "self": {
            "href": "http://rest.neftika-card.ru/v01/cards?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY%3D&page=1"
        },
        "next": {
            "href": "http://rest.neftika-card.ru/v01/cards?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY%3D&page=2"
        },
        "last": {
            "href": "http://rest.neftika-card.ru/v01/cards?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY%3D&page=101"
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


Запрос

~~~http
http://rest.neftika-card.ru/v01/cards?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&expand=purses
~~~

Пример вывода

~~~json
{
    "cards": [
        {
            "ID_CARD": 21823,
            "CARD_NUMBER": 648034820,
            "ID_CONDITION": 1,
            "DESCRIPTION_CONDITION": "В работе",
            "purses": [
                {
                    "ID_SERVICES": "14",
                    "SERVICES_DESCRIPTION": "Евро 95/4",
                    "LIMIT_PURSE": "0",
                    "MONTHLY_LIMIT": "1",
                    "INDIVIDUAL_LIMIT": "0"
                },
                {
                    "ID_SERVICES": "13",
                    "SERVICES_DESCRIPTION": "Евро 92/4",
                    "LIMIT_PURSE": "0",
                    "MONTHLY_LIMIT": "1",
                    "INDIVIDUAL_LIMIT": "0"
                },
                {
                    "ID_SERVICES": "1",
                    "SERVICES_DESCRIPTION": "Рубли",
                    "LIMIT_PURSE": "10000",
                    "MONTHLY_LIMIT": "1",
                    "INDIVIDUAL_LIMIT": "1"
                },
                {
                    "ID_SERVICES": "11",
                    "SERVICES_DESCRIPTION": "Бонусы",
                    "LIMIT_PURSE": "0",
                    "MONTHLY_LIMIT": "0",
                    "INDIVIDUAL_LIMIT": "0"
                }
            ]
        },
        {
            "ID_CARD": 20719,
            "CARD_NUMBER": 648033716,
            "ID_CONDITION": 5,
            "DESCRIPTION_CONDITION": "Заблокирована",
            "purses": [
                {
                    "ID_SERVICES": "13",
                    "SERVICES_DESCRIPTION": "Евро 92/4",
                    "LIMIT_PURSE": "100",
                    "MONTHLY_LIMIT": "0",
                    "INDIVIDUAL_LIMIT": "0"
                },
                {
                    "ID_SERVICES": "4",
                    "SERVICES_DESCRIPTION": "Аи-92",
                    "LIMIT_PURSE": "100",
                    "MONTHLY_LIMIT": "0",
                    "INDIVIDUAL_LIMIT": "0"
                },
                {
                    "ID_SERVICES": "11",
                    "SERVICES_DESCRIPTION": "Бонусы",
                    "LIMIT_PURSE": "0",
                    "MONTHLY_LIMIT": "0",
                    "INDIVIDUAL_LIMIT": "0"
                }
            ]
        },
],
    "_links": {
        "self": {
            "href": "http://rest.neftika-card.ru/v01/cards?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY%3D&expand=purses&page=1"
        },
        "next": {
            "href": "http://rest.neftika-card.ru/v01/cards?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY%3D&expand=purses&page=2"
        },
        "last": {
            "href": "http://rest.neftika-card.ru/v01/cards?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY%3D&expand=purses&page=101"
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

Запрос

~~~http
http://rest.neftika-card.ru/v01/cards/648034820?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=
http://rest.neftika-card.ru/v01/cards/648034820?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&expand=purses
~~~

Пример вывода

~~~json
{
    "ID_CARD": 21823,
    "CARD_NUMBER": 648034820,
    "ID_CONDITION": 5,
    "DESCRIPTION_CONDITION": "Заблокирована",
    "purses": [
        {
            "ID_SERVICES": "14",
            "SIZE_PURSE": "0",
            "SERVICES_DESCRIPTION": "Евро 95/4"
        },
        {
            "ID_SERVICES": "13",
            "SIZE_PURSE": "0",
            "SERVICES_DESCRIPTION": "Евро 92/4"
        },
        {
            "ID_SERVICES": "1",
            "SIZE_PURSE": "0",
            "SERVICES_DESCRIPTION": "Рубли"
        },
        {
            "ID_SERVICES": "11",
            "SIZE_PURSE": "0",
            "SERVICES_DESCRIPTION": "Бонусы"
        }
    ]
}
~~~

Обновление статуса карты <span id="card-update"></span>
-------------------------

Обновление статуса карты производится методом `PUT`. Формат закроса должен включат переменную status которая может принимать следующие значения `status=1` карат в работе, `status=0` карта заблокирована. Примеры запросов и ответы

~~~http
http://rest.neftika-card.ru/v01/cards/648034820?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&status=0
~~~

~~~json
{
    "result": 1,
    "card": {
        "ID_CARD": 21823,
        "CARD_NUMBER": 648034820,
        "ID_CONDITION": 5,
        "DESCRIPTION_CONDITION": "Заблокирована"
    }
}
~~~

~~~http
http://rest.neftika-card.ru/v01/cards/648034820?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&status=1
~~~

~~~json
{
    "result": 1,
    "card": {
        "ID_CARD": 21823,
        "CARD_NUMBER": 648034820,
        "ID_CONDITION": 1,
        "DESCRIPTION_CONDITION": "В работе"
    }
}
~~~

В случае если обращение идет к карте с незарегистрированным номером выдается следующий результат

~~~http
http://rest.neftika-card.ru/v01/cards/648099999?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&status=1
~~~

~~~json
{
    "result": 0,
    "card": null
}
~~~
