# Webscraper

## Api
To make authenticated requests via http using the built in methods, you will need to set an authorization header as follows:

``` Authorization: Bearer {your_token_here} ```

Alternatively you can include the token via a query string:

``` http://api.mysite.com/me?token={your_token_here} ```

---
##### /api/me
info of token bearer
```json
{
	"data": {
		"first_name": "Yaro",
		"last_name": "Beefeater",
		"email": "yaro@beefeater.xxx"
	}
}
```

##### /api/email/{encoded_url}
```json
{
	"data": {
		"url": "http:\/\/cherry-pie.co",
		"emails": [
			"sexy@cherry-pie.co"
		],
		"contacts": [
			"http:\/\/cherry-pie.co\/about-us",
			"http:\/\/cherry-pie.co\/contact"
		]
	}
}
```
