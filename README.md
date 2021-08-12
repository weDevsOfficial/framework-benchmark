# Framework Benchmark

The goal of this repository is to benchmark popular frameworks to be used as a REST API in their optimal configuration. 

## Ideal Setup

- Disabled session
- Optimized suggested state for the framework 

## Testing Criteria

- `/` : Returns a simple *Hello World* JSON response.
- `/users` : Returns a list of users from the database.
- `/compute` : Compute the first 10,000 Fibonacci numbers.

## Frameworks

- [Flight](https://github.com/mikecao/flight) *(v1.3)*

## Running Benchmark

```
ab -t 10 -c 10 http://server.address/
```