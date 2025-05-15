# Coffee Machine
## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `make start` to install the project
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
4.1 A react app is also available at `http://localhost:3000/`
5. Run `make down` to stop the Docker containers.

## Features
### API
- Get the status of the coffee machine
```shell
curl --request GET \
--url https://localhost/api/coffee-machine/status \
--header 'Content-Type: application/json'
```

- Start the coffee machine
```shell
curl --request POST \
--url https://localhost/api/coffee-machine/start \
--header 'Content-Type: application/json'
```
- Stop the coffee machine
```shell
curl --request POST \
--url https://localhost/api/coffee-machine/stop \
--header 'Content-Type: application/json'
```
- Order a coffee
```shell
curl --request PUT \
--url https://localhost/api/coffee-machine/order \
--header 'Content-Type: application/json' \
--data '{
    "size": "regular",
    "intensity": 5
}'
```
- Get the order history
```shell
curl --request GET \
--url https://localhost/api/coffee/completed \
--header 'Content-Type: application/json'
```
- Get the processing order
```shell
curl --request GET \
--url https://localhost/api/coffee/processing \
--header 'Content-Type: application/json'
```
- Get the pending orders
```shell
curl --request GET \
--url https://localhost/api/coffee/pending \
--header 'Content-Type: application/json'
```
- Cancel a coffee (is it worth it?)
```shell
curl --request POST \
--url https://localhost/api/coffee/{orderId}/cancel \
--header 'Content-Type: application/json'
```
**Enjoy your coffee!**
