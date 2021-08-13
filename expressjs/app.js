const express = require('express');

const app = express();

// Parse the application/json request body.
app.use(express.json());
// Parse the x-www-form-urlencoded request body.
app.use(express.urlencoded({ extended: true }));

const { Sequelize } = require('sequelize');

// Option 2: Passing parameters separately (sqlite)
const sequelize = new Sequelize({
    dialect: 'sqlite',
    storage: 'database.sqlite'
});

async function connectDb() {
    try {
        await sequelize.authenticate();
        console.log('Connection has been established successfully.');
    } catch (error) {
        console.error('Unable to connect to the database:', error);
    }
}
const User = sequelize.define('user', {
    name: {
        type: Sequelize.STRING,
        allowNull: false
    },
    email: {
        type: Sequelize.STRING,
        allowNull: false
    },
    password: {
        type: Sequelize.STRING,
        allowNull: false
    }
}, {
    // options
});
connectDb().then(result => {
    app.get('/ping', function (req, res) {
        return res.json({ message: 'pong' });
    });

    app.get('/compute', function (req, res) {
        let x = 0;
        let y = 1;
        let max = 10000;

        for (let i = 0; i <= max; i++) {
            z = x + y;
            x = y;
            y = z;
        }
        return res.json({ message: 'Done' });
    });

    app.post('/users', function (req, res) {
        const { name, email, password } = req.body;
        User.create({ name, email, password, createdAt: new Date(), updatedAt: new Date() })
            .then(user => res.status(201).json(user))
            .catch(err => res.status(500).json(err));
    });

    app.get('/users', function (req, res) {
        User.findAll().then(users => res.json(users));
    })

    // Helper Route. Doesn't affect the benchmarkable routes.
    app.get('/generate', async function (req, res) {
        for (let i = 0; i < 50; i++) {
            await User.create({
                name: 'John Doe',
                email: 'john@example.com',
                password: 'password'
            });
        }
        User.findAll().then(users => res.json(users));
    });

    // Helper Route. Doesn't affect the benchmarkable routes.
    app.get('/truncate', async function (req, res) {
        await User.destroy({ truncate: true, restartIdentity: true });
        await sequelize.query("UPDATE SQLITE_SEQUENCE SET SEQ=0 WHERE NAME='users'");
        return res.json({ message: 'Table deleted' });
    });

    app.listen(8000, async () => {
        // await sequelize.sync({ force: true });
        sequelize.query("CREATE TABLE IF NOT EXISTS `users` (`id` INTEGER PRIMARY KEY AUTOINCREMENT, `name` VARCHAR(255) NOT NULL, `email` VARCHAR(255) NOT NULL, `password` VARCHAR(255) NOT NULL, `createdAt` DATETIME NOT NULL, `updatedAt` DATETIME NOT NULL);").then(result => {
            console.log(`Example app listening at http://localhost:8000`)
        })
        // console.log(`Example app listening at http://localhost:8000`)
    });
});
