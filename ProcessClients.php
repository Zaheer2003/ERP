<?php
// Include database connection
include('db_connect.php'); 

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize data
    $client_type = $_POST['clientType'];  // Fix this by using the correct form name
    $telephone = $_POST['telephone'];
    $mobile = $_POST['mobile'];
    $street_address1 = $_POST['street_address1'];
    $street_address2 = $_POST['street_address2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postal_code = $_POST['postal_code'];
    $country = $_POST['country'];
    $vat_number = $_POST['vat_number'];
    $code_number = $_POST['code_number'];
    $currency = $_POST['currency'];
    $email = $_POST['email'];
    $category = $_POST['category'];
    $notes = $_POST['notes'];
    $language = $_POST['language'];
    $invoicing_method = $_POST['invoicing_method'];

    // Sanitize the inputs
    $client_type = filter_var($client_type, FILTER_SANITIZE_STRING);
    $telephone = filter_var($telephone, FILTER_SANITIZE_STRING);
    $mobile = filter_var($mobile, FILTER_SANITIZE_STRING);
    $street_address1 = filter_var($street_address1, FILTER_SANITIZE_STRING);
    $street_address2 = filter_var($street_address2, FILTER_SANITIZE_STRING);
    $city = filter_var($city, FILTER_SANITIZE_STRING);
    $state = filter_var($state, FILTER_SANITIZE_STRING);
    $postal_code = filter_var($postal_code, FILTER_SANITIZE_STRING);
    $country = filter_var($country, FILTER_SANITIZE_STRING);
    $vat_number = filter_var($vat_number, FILTER_SANITIZE_STRING);
    $code_number = filter_var($code_number, FILTER_SANITIZE_STRING);
    $currency = filter_var($currency, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $notes = filter_var($notes, FILTER_SANITIZE_STRING);
    $language = filter_var($language, FILTER_SANITIZE_STRING);
    $invoicing_method = filter_var($invoicing_method, FILTER_SANITIZE_STRING);

    // Prepare SQL query based on client type
    try {
        if ($client_type == 'individual') {
            // Individual client form
            $name = filter_var($_POST['individual_name'], FILTER_SANITIZE_STRING);

            $sql = "INSERT INTO clients (client_type, name, telephone, mobile, street_address1, street_address2, city, state, postal_code, country, vat_number, code_number, currency, email, category, notes, language, invoicing_method)
                    VALUES (:client_type, :name, :telephone, :mobile, :street_address1, :street_address2, :city, :state, :postal_code, :country, :vat_number, :code_number, :currency, :email, :category, :notes, :language, :invoicing_method)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
        } elseif ($client_type == 'business') {
            // Business client form
            $business_name = filter_var($_POST['business_name'], FILTER_SANITIZE_STRING);
            $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
            $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);

            $sql = "INSERT INTO clients (client_type, business_name, first_name, last_name, telephone, mobile, street_address1, street_address2, city, state, postal_code, country, vat_number, code_number, currency, email, category, notes, language, invoicing_method)
                    VALUES (:client_type, :business_name, :first_name, :last_name, :telephone, :mobile, :street_address1, :street_address2, :city, :state, :postal_code, :country, :vat_number, :code_number, :currency, :email, :category, :notes, :language, :invoicing_method)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':business_name', $business_name);
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
        } else {
            throw new Exception("Invalid client type.");
        }

        // Bind common parameters
        $stmt->bindParam(':client_type', $client_type);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':street_address1', $street_address1);
        $stmt->bindParam(':street_address2', $street_address2);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':postal_code', $postal_code);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':vat_number', $vat_number);
        $stmt->bindParam(':code_number', $code_number);
        $stmt->bindParam(':currency', $currency);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':notes', $notes);
        $stmt->bindParam(':language', $language);
        $stmt->bindParam(':invoicing_method', $invoicing_method);

        // Execute query
        $stmt->execute();

        // Redirect to a success page or display a success message
        header("Location: AddClients.php?success=1");
        exit();
    } catch (PDOException $e) {
        error_log("SQL Error: " . $e->getMessage(), 3, 'error_log.txt');
        echo "Error executing query: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
