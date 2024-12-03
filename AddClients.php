<?php 
$pageTitle = "Add New Clients";
include('Header.php'); ?>


<style>
        .breadcrumb-container {
      position: sticky;
      top: 0; /* Keep it at the top */
      background-color: #f8f9fa;
      padding: 15px;
      z-index: 1000; /* Ensure it stays above other content */
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Add shadow for better visibility */
    }

    .breadcrumb a {
      color: #007bff;
      text-decoration: none;
    }

    .breadcrumb a:hover {
      text-decoration: underline;
    }

    .breadcrumb .active {
      color: #6c757d;
    }

    .content {
      height: 2000px; /* Add extra height to enable scrolling */
    }
</style>
<head>

    <title>Add New Clients</title>


</head>



<form method="POST" action="ProcessClients.php" enctype="multipart/form-data">
<div class="container mt-5">
    <div class="row">
        <!-- Client Details Section -->
        <div class="col-sm-12 col-md-6">
        <section class="border rounded p-4 mb-5">
            <div class="card">
                <div class="card-header  bg-primary text-white">
                    <h4>Client Details &nbsp;</h4>
                    </div>

                    <div class="card-body">
                        <!-- Client Type Selection -->
                        <div class="form-group">
                            <label>Client Type</label>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="RBIndividual" name="clientType" value="individual" class="form-check-input" onclick="showForm('individual')" checked>
                                <label class="form-check-label" for="RBIndividual">&nbsp; Individual</label>

                                <input type="radio" id="RBBusiness" name="clientType" value="business" class="form-check-input" onclick="showForm('business')">
                                <label class="form-check-label" for="RBBusiness">&nbsp; Business</label>
                            </div>
                        </div>

                    <!-- Individual Form Fields -->
                    <div id="individual-form">
                        <h5>Individual Information</h5>
                        <div class="form-group">
                            <label for="individualName">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="individual_name" id="individualName" placeholder="Enter Full Name">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="telephone">Telephone</label>
                                <input type="tel" class="form-control" name="individual_telephone" id="telephone" placeholder="Enter Telephone">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="mobile">Mobile</label>
                                <input type="tel" class="form-control" name="individual_mobile" id="mobile" placeholder="Enter Mobile">
                            </div>
                        </div>

                        <!-- Address Fields -->
                        <div class="form-group">
                            <label for="streetAddress1">Address Line 1</label>
                            <input type="text" class="form-control" name="individual_address1" id="streetAddress1" placeholder="Enter Address Line 1">
                        </div>
                        
                        <div class="form-group">
                            <label for="streetAddress2">Address Line 2</label>
                            <input type="text" class="form-control" name="individual_address2" id="streetAddress2" placeholder="Enter Address Line 2">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="city">City</label>
                                <input type="text" class="form-control" name="individual_city" id="city" placeholder="Enter City">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="state">State</label>
                                <input type="text" class="form-control" name="individual_state" id="state" placeholder="Enter State">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" class="form-control" name="individual_postalCode" id="postalCode" placeholder="Enter Postal Code">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="countrySelect">Country</label>
                            <select class="form-control" name="individual_country" id="countrySelect">
                                <option value="LK">Sri Lanka</option>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="GB">United Kingdom</option>
                                <option value="AU">Australia</option>
                                <option value="QA">Qatar</option>
                                <option value="AE">Dubai (United Arab Emirates)</option>
                                <option value="SA">Saudi Arabia</option>
                                <option value="MY">Malaysia</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="vatNumber">VAT Number (Optional)</label>
                            <input type="text" class="form-control" name="individual_vatNumber" id="vatNumber" placeholder="Enter VAT Number">
                        </div>
                    </div>

                    <!-- Business Form Fields -->
                    <div id="business-form" style="display:none;">
                        <h5>Business Information</h5>

                        <!-- Business Name -->
                        <div class="form-group">
                            <label for="businessName">Business Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="business_name" id="businessName" placeholder="Enter Business Name">
                        </div>

                        <!-- First Name -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" name="first_name" id="firstName" placeholder="Enter First Name">
                            </div>

                            <!-- Last Name -->
                            <div class="form-group col-md-6">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="lastName" placeholder="Enter Last Name">
                            </div>
                        </div>

                        <!-- Telephone and Mobile -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="telephone">Telephone</label>
                                <input type="tel" class="form-control" name="telephone" id="telephone" placeholder="Enter Telephone">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="mobile">Mobile</label>
                                <input type="tel" class="form-control" name="mobile" id="mobile" placeholder="Enter Mobile">
                            </div>
                        </div>

                        <!-- Address Fields -->
                        <div class="form-group">
                            <label for="streetAddress1">Address Line 1</label>
                            <input type="text" class="form-control" name="street_address1" id="streetAddress1" placeholder="Enter Address Line 1">
                        </div>

                        <div class="form-group">
                            <label for="streetAddress2">Address Line 2</label>
                            <input type="text" class="form-control" name="street_address2" id="streetAddress2" placeholder="Enter Address Line 2">
                        </div>

                        <!-- City, State, Postal Code -->
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="city">City</label>
                                <input type="text" class="form-control" name="city" id="city" placeholder="Enter City">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="state">State</label>
                                <input type="text" class="form-control" name="state" id="state" placeholder="Enter State">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" class="form-control" name="postal_code" id="postalCode" placeholder="Enter Postal Code">
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="form-group">
                            <label for="countrySelect">Country</label>
                            <select class="form-control" name="country" id="countrySelect">
                                <option value="LK">Sri Lanka</option>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="GB">United Kingdom</option>
                                <option value="AU">Australia</option>
                                <option value="QA">Qatar</option>
                                <option value="AE">Dubai (United Arab Emirates)</option>
                                <option value="SA">Saudi Arabia</option>
                                <option value="MY">Malaysia</option>
                            </select>
                        </div>

                        <!-- VAT Number -->
                        <div class="form-group">
                            <label for="vatNumber">VAT Number (Optional)</label>
                            <input type="text" class="form-control" name="vat_number" id="vatNumber" placeholder="Enter VAT Number">
                        </div>
                    </div>

                </div>
            </div>
            </section>
        </div>
        

<!-- Account Details Section -->
<div class="col-sm-12 col-md-6">
<section class="border rounded p-4 mb-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Account Details</h4>
            </div>
            <div class="card-body">

            <!-- Code Number -->
            <div class="form-group">
                <label for="codeNumber">Code Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="code_number" id="codeNumber" placeholder="000005">
            </div>

            <!-- Currency -->
            <div class="form-group">
                <label for="currency">Currency <span class="text-muted" data-toggle="tooltip" title="Select currency for transactions">?</span></label>
                <select class="form-control" name="currency" id="currency">
                    <option value="LKR" selected>LKR Sri Lankan Rupee</option>
                    <option value="USD">USD United States Dollar</option>
                    <option value="EUR">EUR Euro</option>
                    <option value="GBP">GBP British Pound</option>
                    <option value="AUD">AUD Australian Dollar</option>
                </select>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
            </div>

            <!-- Category -->
            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control" name="category" id="category">
                    <option value="" selected>Select Category</option>
                    <option value="Retail">Retail</option>
                    <option value="Wholesale">Wholesale</option>
                    <option value="Service">Service</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <!-- Notes -->
            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea class="form-control" name="notes" id="notes" rows="3" placeholder="Enter any additional notes"></textarea>
            </div>

            <!-- Attachments -->
            <div class="form-group">
                <label for="attachments">Attachments</label>
                <div class="border p-3 text-center">
                    <i data-feather="upload-cloud" style="font-size: 2rem;"></i>
                    <p class="mt-2">Drag & Drop files here or <a href="#" id="select-files">select from your computer</a></p>
                    <input type="file" class="form-control-file" name="attachments[]" id="attachments" multiple style="display:none;" onchange="updateFileNames()">
                    <div id="file-names" class="mt-2 text-muted">No files selected</div>
                </div>
            </div>

            <!-- Display Language -->
            <div class="form-group">
                <label for="language">Display Language</label>
                <select class="form-control" name="language" id="language">
                    <option value="en" selected>English</option>
                    <option value="si">Sinhala</option>
                    <option value="ta">Tamil</option>
                </select>
            </div>

            <!-- Invoicing Method -->
            <div class="form-group">
                <label for="invoicingMethod">Invoicing Method</label>
                <select class="form-control" name="invoicing_method" id="invoicingMethod">
                    <option value="Print" selected>Print (Offline)</option>
                    <option value="Email">Email</option>
                    <option value="Online">Online Portal</option>
                </select>
            </div>
        </div>
    </div>
    </section>
</div>
<div class="text-center">
<button type="submit" class="btn btn-primary">Submit</button>
</div>

                   
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<script>
function showForm(clientType) {
    if (clientType === 'individual') {
        document.getElementById('individual-form').style.display = 'block';
        document.getElementById('business-form').style.display = 'none';
    } else {
        document.getElementById('individual-form').style.display = 'none';
        document.getElementById('business-form').style.display = 'block';
    }
}
</script>

<?php include('Footer.php'); ?> 
