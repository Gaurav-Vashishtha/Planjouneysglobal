

    <style>
            .cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            background: #0097A7;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 220px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .card a {
            color: #fff;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .card a i {
            margin-left: 5px;
        }
    </style>

<div class="dashboard">
    <h2>Dashboard</h2>
    <div class="cards">
        <div class="card">
            <h3>0</h3>
            <p>Users</p>
        </div>
        <div class="card">
            <h3>0</h3>
            <p>Bookings</p>
        </div>
    </div>
</div>
