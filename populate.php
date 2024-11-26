<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Lab 9</title>
</head>
<body>
    <h1>Populate Tables</h1>

    <form action='populate.php' method='POST'>
        <label for='table'>Choose a table to populate<br>
            <input type='radio' name='table' value='VENUE' required>VENUE</input><br>
            <input type='radio' name='table' value='TICKET'>TICKET</input><br>
            <input type='radio' name='table' value='PAYMENT'>PAYMENT</input><br>
            <input type='radio' name='table' value='ORDERS'>ORDERS</input><br>
            <input type='radio' name='table' value='ORDERED_TICKETS'>ORDERED_TICKETS</input><br>
            <input type='radio' name='table' value='EVENT'>EVENT</input><br>
            <input type='radio' name='table' value='CUSTOMER'>CUSTOMER</input><br>
            <input type='radio' name='table' value='ALL'>ALL</input><br>
        </label><br>

        <button type='submit'>Populate</button>
    </form>

    <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
        // Create connection to Oracle
        $conn = oci_connect('s3pham', '10080284',
        '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(Host=oracle12c.cs.torontomu.ca)(Port=1521))(CONNECT_DATA=(SID=orcl12c)))');
        if (!$conn) {
            $m = oci_error();
            echo $m['message'];
            die();
        }
        else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
                $table = htmlspecialchars($_POST['table']);
                
                if ($table == "PAYMENT") {
                    $queries = ["INSERT INTO Payment (payment_id, name, card_number, cvc, expiry, billing_address, type)
                        VALUES ('PaymentID1', 'Stewart Bustard', '5519090012568798', 123, TO_DATE('09/27', 'MM/YY'), 
                                '123 Random Cr, Toronto, Ontario, Canada, L1H2M9', 'Mastercard')",

                        "INSERT INTO Payment (payment_id, name, card_number, cvc, expiry, billing_address, type)
                        VALUES ('PaymentID2', 'Grace Chant', '4718456712986839', 741, TO_DATE('12/25', 'MM/YY'), 
                                '98 Some St, Toronto, Ontario, Canada, M2A9P2', 'Visa')",

                        "INSERT INTO Payment (payment_id, name, card_number, cvc, expiry, billing_address, type)
                        VALUES ('PaymentID3', 'Jason Truong', '4912048294581029', 923, TO_DATE('10/29', 'MM/YY'), 
                                '103 Any Dr, Toronto, Ontario, Canada, P2E3A0', 'Visa')"];
                } elseif ($table == "CUSTOMER") {
                    $queries = ["INSERT INTO Customer (customer_id, name, email, phone_number, payment_id)
                        VALUES ('CustomerID1', 'Stewart Bustard', 'stewartbustard@gmail.com', '(416) 891-2301', 'PaymentID1')",

                        "INSERT INTO Customer (customer_id, name, email, phone_number, payment_id)
                        VALUES ('CustomerID2', 'Grace Chant', 'gracechant@gmail.com', '(647) 784-6314', 'PaymentID2')",

                        "INSERT INTO Customer (customer_id, name, email, payment_id)
                        VALUES ('CustomerID3', 'Jason Truong', 'jasontruong@gmail.com', 'PaymentID3')",

                        "INSERT INTO Customer (customer_id, name, email, phone_number)
                        VALUES ('CustomerID4', 'John Doe', 'johndoe@gmail.com', '(647) 123-4567')",

                        "INSERT INTO Customer (customer_id, name, email)
                        VALUES ('CustomerID5', 'John Smith', 'jsmith@yahoo.ca')"];
                } elseif ($table == "VENUE") {
                    $queries = ["INSERT INTO Venue (venue_id, name, location, capacity)
                        VALUES ('VenueID1', 'Scotiabank Arena', '40 Bay St, Toronto, Ontario, Canada, M5J2X2', 19800)",

                        "INSERT INTO Venue (venue_id, name, location, capacity)
                        VALUES ('VenueID2', 'Coca-Cola Coliseum', '45 Manitoba Dr, Toronto, Ontario, Canada, M6K3C3', 7779)",

                        "INSERT INTO Venue (venue_id, name, location, capacity)
                        VALUES ('VenueID3', 'Rogers Centre', '1 Blue Jays Way, Toronto, Ontario, Canada, M5V1J1', 49286)",

                        "INSERT INTO Venue (venue_id, name, location, capacity)
                        VALUES ('VenueID4', 'Danforth Music Hall', '147 Danforth Ave, Toronto, Ontario, Canada, M4K1N2', 1500)"];
                } elseif ($table == "EVENT") {
                    $queries = ["INSERT INTO Event (event_id, name, category, venue_id)
                        VALUES ('EventID1', 'Drake World Tour', 'Music', 'VenueID1')",

                        "INSERT INTO Event (event_id, name, category, venue_id)
                        VALUES ('EventID2', 'Chris Rock Comedy Club', 'Comedy', 'VenueID2')",

                        "INSERT INTO Event (event_id, name, category, venue_id)
                        VALUES ('EventID3', 'The Weeknd North American Tour', 'Music', 'VenueID3')",

                        "INSERT INTO Event (event_id, name, category, venue_id)
                        VALUES ('EventID4', 'The Lion King', 'Movie', 'VenueID2')"];
                } elseif ($table == "TICKET") {
                    $queries = ["INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID1', 'Drake World Tour General Admission', 7994, 300, 'EventID1')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID2', 'Drake World Tour VIP', 1998, 500, 'EventID1')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID3', 'Chris Rock Comedy Club General Admission', 6999, 125, 'EventID2')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID4', 'The Weeknd Section A', 499, 250, 'EventID3')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID5', 'The Weeknd Section B', 500, 250, 'EventID3')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID6', 'The Weeknd Section C', 500, 250, 'EventID3')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID7', 'The Weeknd Section D', 497, 250, 'EventID3')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID8', 'The Weeknd Section E', 500, 250, 'EventID3')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID9', 'The Weeknd Section F', 0, 250, 'EventID3')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID10', 'The Lion King General Admission', 0, 13, 'EventID4')"];
                } elseif ($table == "ORDERS") {
                    $queries = ["INSERT INTO Orders (order_id, total_amount, order_date, customer_id)
                        VALUES ('OrderID1', 600, TO_DATE('2024-09-24', 'YYYY-MM-DD'), 'CustomerID1')",

                        "INSERT INTO Orders (order_id, total_amount, order_date, customer_id)
                        VALUES ('OrderID2', 125, TO_DATE('2024-09-25', 'YYYY-MM-DD'), 'CustomerID1')",

                        "INSERT INTO Orders (order_id, total_amount, order_date, customer_id)
                        VALUES ('OrderID3', 1000, TO_DATE('2024-09-26', 'YYYY-MM-DD'), 'CustomerID2')",

                        "INSERT INTO Orders (order_id, total_amount, order_date, customer_id)
                        VALUES ('OrderID4', 250, TO_DATE('2024-09-27', 'YYYY-MM-DD'), 'CustomerID2')",

                        "INSERT INTO Orders (order_id, total_amount, order_date, customer_id)
                        VALUES ('OrderID5', 750, TO_DATE('2024-09-28', 'YYYY-MM-DD'), 'CustomerID3')",

                        "INSERT INTO Orders (order_id, total_amount, order_date, customer_id)
                        VALUES ('OrderID6', 1200, TO_DATE('2024-09-29', 'YYYY-MM-DD'), 'CustomerID3')"];
                } elseif ($table == "ORDERED_TICKETS") {
                    $queries = ["INSERT INTO Ordered_Tickets (order_id, ticket_id, seat, quantity)
                        VALUES ('OrderID1', 'TicketID1', 'GA', 2)",

                        "INSERT INTO Ordered_Tickets (order_id, ticket_id, seat, quantity)
                        VALUES ('OrderID2', 'TicketID3', 'GA', 1)",

                        "INSERT INTO Ordered_Tickets (order_id, ticket_id, seat, quantity)
                        VALUES ('OrderID3', 'TicketID2', 'VIP', 2)",

                        "INSERT INTO Ordered_Tickets (order_id, ticket_id, seat, quantity)
                        VALUES ('OrderID4', 'TicketID4', 'A15', 1)",

                        "INSERT INTO Ordered_Tickets (order_id, ticket_id, seat, quantity)
                        VALUES ('OrderID5', 'TicketID7', 'D9', 1)",

                        "INSERT INTO Ordered_Tickets (order_id, ticket_id, seat, quantity)
                        VALUES ('OrderID5', 'TicketID7', 'D10', 1)",

                        "INSERT INTO Ordered_Tickets (order_id, ticket_id, seat, quantity)
                        VALUES ('OrderID5', 'TicketID7', 'D11', 1)",

                        "INSERT INTO Ordered_Tickets (order_id, ticket_id, seat, quantity)
                        VALUES ('OrderID6', 'TicketID1', 'GA', 4)"];
                }
                elseif ($table == "ALL") {
                    $queries = ["INSERT INTO Payment (payment_id, name, card_number, cvc, expiry, billing_address, type)
                        VALUES ('PaymentID1', 'Stewart Bustard', '5519090012568798', 123, TO_DATE('09/27', 'MM/YY'), 
                                '123 Random Cr, Toronto, Ontario, Canada, L1H2M9', 'Mastercard')",

                        "INSERT INTO Payment (payment_id, name, card_number, cvc, expiry, billing_address, type)
                        VALUES ('PaymentID2', 'Grace Chant', '4718456712986839', 741, TO_DATE('12/25', 'MM/YY'), 
                                '98 Some St, Toronto, Ontario, Canada, M2A9P2', 'Visa')",

                        "INSERT INTO Payment (payment_id, name, card_number, cvc, expiry, billing_address, type)
                        VALUES ('PaymentID3', 'Jason Truong', '4912048294581029', 923, TO_DATE('10/29', 'MM/YY'), 
                                '103 Any Dr, Toronto, Ontario, Canada, P2E3A0', 'Visa')",

                        "INSERT INTO Customer (customer_id, name, email, phone_number, payment_id)
                        VALUES ('CustomerID1', 'Stewart Bustard', 'stewartbustard@gmail.com', '(416) 891-2301', 'PaymentID1')",

                        "INSERT INTO Customer (customer_id, name, email, phone_number, payment_id)
                        VALUES ('CustomerID2', 'Grace Chant', 'gracechant@gmail.com', '(647) 784-6314', 'PaymentID2')",

                        "INSERT INTO Customer (customer_id, name, email, payment_id)
                        VALUES ('CustomerID3', 'Jason Truong', 'jasontruong@gmail.com', 'PaymentID3')",

                        "INSERT INTO Customer (customer_id, name, email, phone_number)
                        VALUES ('CustomerID4', 'John Doe', 'johndoe@gmail.com', '(647) 123-4567')",

                        "INSERT INTO Customer (customer_id, name, email)
                        VALUES ('CustomerID5', 'John Smith', 'jsmith@yahoo.ca')",

                        "INSERT INTO Venue (venue_id, name, location, capacity)
                        VALUES ('VenueID1', 'Scotiabank Arena', '40 Bay St, Toronto, Ontario, Canada, M5J2X2', 19800)",

                        "INSERT INTO Venue (venue_id, name, location, capacity)
                        VALUES ('VenueID2', 'Coca-Cola Coliseum', '45 Manitoba Dr, Toronto, Ontario, Canada, M6K3C3', 7779)",

                        "INSERT INTO Venue (venue_id, name, location, capacity)
                        VALUES ('VenueID3', 'Rogers Centre', '1 Blue Jays Way, Toronto, Ontario, Canada, M5V1J1', 49286)",

                        "INSERT INTO Venue (venue_id, name, location, capacity)
                        VALUES ('VenueID4', 'Danforth Music Hall', '147 Danforth Ave, Toronto, Ontario, Canada, M4K1N2', 1500)",

                        "INSERT INTO Event (event_id, name, category, venue_id)
                        VALUES ('EventID1', 'Drake World Tour', 'Music', 'VenueID1')",

                        "INSERT INTO Event (event_id, name, category, venue_id)
                        VALUES ('EventID2', 'Chris Rock Comedy Club', 'Comedy', 'VenueID2')",

                        "INSERT INTO Event (event_id, name, category, venue_id)
                        VALUES ('EventID3', 'The Weeknd North American Tour', 'Music', 'VenueID3')",

                        "INSERT INTO Event (event_id, name, category, venue_id)
                        VALUES ('EventID4', 'The Lion King', 'Movie', 'VenueID2')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID1', 'Drake World Tour General Admission', 7994, 300, 'EventID1')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID2', 'Drake World Tour VIP', 1998, 500, 'EventID1')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID3', 'Chris Rock Comedy Club General Admission', 6999, 125, 'EventID2')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID4', 'The Weeknd Section A', 499, 250, 'EventID3')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID5', 'The Weeknd Section B', 500, 250, 'EventID3')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID6', 'The Weeknd Section C', 500, 250, 'EventID3')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID7', 'The Weeknd Section D', 497, 250, 'EventID3')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID8', 'The Weeknd Section E', 500, 250, 'EventID3')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID9', 'The Weeknd Section F', 0, 250, 'EventID3')",

                        "INSERT INTO Ticket (ticket_id, ticket_name, quantity, unit_price, event_id)
                        VALUES ('TicketID10', 'The Lion King General Admission', 0, 13, 'EventID4')",

                        "INSERT INTO Orders (order_id, total_amount, order_date, customer_id)
                        VALUES ('OrderID1', 600, TO_DATE('2024-09-24', 'YYYY-MM-DD'), 'CustomerID1')",

                        "INSERT INTO Orders (order_id, total_amount, order_date, customer_id)
                        VALUES ('OrderID2', 125, TO_DATE('2024-09-25', 'YYYY-MM-DD'), 'CustomerID1')",

                        "INSERT INTO Orders (order_id, total_amount, order_date, customer_id)
                        VALUES ('OrderID3', 1000, TO_DATE('2024-09-26', 'YYYY-MM-DD'), 'CustomerID2')",

                        "INSERT INTO Orders (order_id, total_amount, order_date, customer_id)
                        VALUES ('OrderID4', 250, TO_DATE('2024-09-27', 'YYYY-MM-DD'), 'CustomerID2')",

                        "INSERT INTO Orders (order_id, total_amount, order_date, customer_id)
                        VALUES ('OrderID5', 750, TO_DATE('2024-09-28', 'YYYY-MM-DD'), 'CustomerID3')",

                        "INSERT INTO Orders (order_id, total_amount, order_date, customer_id)
                        VALUES ('OrderID6', 1200, TO_DATE('2024-09-29', 'YYYY-MM-DD'), 'CustomerID3')",

                        "INSERT INTO Ordered_Tickets (order_id, ticket_id, seat, quantity)
                        VALUES ('OrderID1', 'TicketID1', 'GA', 2)",

                        "INSERT INTO Ordered_Tickets (order_id, ticket_id, seat, quantity)
                        VALUES ('OrderID2', 'TicketID3', 'GA', 1)",

                        "INSERT INTO Ordered_Tickets (order_id, ticket_id, seat, quantity)
                        VALUES ('OrderID3', 'TicketID2', 'VIP', 2)",

                        "INSERT INTO Ordered_Tickets (order_id, ticket_id, seat, quantity)
                        VALUES ('OrderID4', 'TicketID4', 'A15', 1)",

                        "INSERT INTO Ordered_Tickets (order_id, ticket_id, seat, quantity)
                        VALUES ('OrderID5', 'TicketID7', 'D9', 1)",

                        "INSERT INTO Ordered_Tickets (order_id, ticket_id, seat, quantity)
                        VALUES ('OrderID5', 'TicketID7', 'D10', 1)",

                        "INSERT INTO Ordered_Tickets (order_id, ticket_id, seat, quantity)
                        VALUES ('OrderID5', 'TicketID7', 'D11', 1)",

                        "INSERT INTO Ordered_Tickets (order_id, ticket_id, seat, quantity)
                        VALUES ('OrderID6', 'TicketID1', 'GA', 4)"];
                }

                foreach ($queries as $query) {
                    $stid = oci_parse($conn, $query);
                    $r = oci_execute($stid);

                    if (!$r) {
                        $m = oci_error();
                        echo $m['message'];
                        break;
                    }
                }

                if ($r) {
                    if ($table == "ALL") {
                        echo "All tables were successfully populated!";
                    } else {
                        echo "{$table} was successfully populated!";
                    }
                    oci_commit($conn);
                }
            }
        }
    ?>
    <br>
    <a href="lab9.php">
        <button>Back</button>
    </a>
</body>
</html>