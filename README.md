# App



##MongoDB query
`db.createCollection("logs", {capped: true, size: 1000000000} )`

`db.logs.createIndex({time: 1});`