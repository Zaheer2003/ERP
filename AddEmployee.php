<?php
include 'Header.php';
include 'db_connect.php';  
include 'empProcess.php'; // Include the database connection file



// Function to send an email with registration details

?>





<!-- Display error or success message -->
<?php if (isset($errorMessage)) { echo "<p class='text-danger text-center'>$errorMessage</p>"; } ?>
<?php if (isset($successMessage)) { echo "<p class='text-success text-center'>$successMessage</p>"; } ?>

<form method="post" enctype="multipart/form-data">
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3>General Information</h3>
                    </div>
                    <div class="card-body">
                        <!-- First Name, Surname, and Middle Name -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                 <label for="firstName" class="form-label">Username (First Name) <span class="text-danger">*</span></label>
                                <input type="text" name="firstName" id="firstName" class="form-control" placeholder="Enter Username" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="surname" class="form-label">Surname <span class="text-danger">*</span></label>
                                <input type="text" name="surname" id="surname" class="form-control" placeholder="Enter Surname" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="middleName" class="form-label">Middle Name</label>
                                <input type="text" name="middleName" id="middleName" class="form-control" placeholder="Enter Middle Name">
                            </div>
                        </div>

                        <!-- Picture and Notes -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="employeePicture" class="form-label">Employee Picture <span class="text-danger">*</span></label>
                                <input type="file" name="employeePicture" id="employeePicture" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes" id="notes" class="form-control" placeholder="Add notes here"></textarea>
                            </div>
                        </div>

                        <!-- Email and Status -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="allowAccess" class="form-label">Allow access to the system</label>
                    <input type="checkbox" name="allowAccess" id="allowAccess" class="form-check-input">
                </div>
                <div class="col-md-6 mb-3" id="sendCredentialsSection" style="display: none;">
                    <label for="sendCredentials" class="form-label">Send credentials to employee</label>
                    <input type="checkbox" name="sendCredentials" id="sendCredentials" class="form-check-input">
                </div>
            </div>

            <!-- Role and Language section (depends on "Allow access to the system") -->
            <div id="roleAndLanguageSection" style="display: none;">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="">Select Role</option>
                            <option value="Manager">Manager</option>
                            <option value="Employee">Employee</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="displayLanguage" class="form-label">Language</label>
                        <select name="displayLanguage" id="displayLanguage" class="form-select">
                            <option value="English">English</option>
                            <option value="Tamil">Tamil</option>
                        </select>
                    </div>
                </div>
            </div>


                        <div class="card mt-6">
                        <div class="card-header bg-primary text-white" >
                            <h4>Employee Information</h4>
                            </div>
                            </div>

<!-- Collapsible Personal Information Section -->
<div class="card mt-4">
    <div class="card-header">
        <a class="btn btn-link text-decoration-none" data-bs-toggle="collapse" href="#personalInfo" role="button" aria-expanded="false" aria-controls="personalInfo">
            <strong>Personal Information</strong>
        </a>
    </div>
    <div class="collapse" id="personalInfo">
        <div class="card-body">
            <div class="row">
            <div class="col-md-6 mb-3">
                <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                <input type="date" name="dob" id="dob" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" id="gender" class="form-select">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            </div>
            <!-- Country and Citizenship Status -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                <select name="country" class="form-select" required>
                    <option value="">Please Select</option>
                    <option value="Sri Lanka">Sri Lanka</option>
                    <!-- Add other countries as needed -->
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="citizenshipStatus" class="form-label">Citizenship Status</label>
                <select name="citizenshipStatus" class="form-select">
                    <option value="">Please Select</option>
                    <option value="Citizen">Citizen</option>
                    <option value="Permanent Resident">Permanent Resident</option>
                    <!-- Other options -->
                </select>
            </div>
        </div>
        </div>
    </div>
</div>

<!-- Collapsible Contact Information Section -->
<div class="card mt-4">
    <div class="card-header">
        <a class="btn btn-link text-decoration-none" data-bs-toggle="collapse" href="#contactInfo" role="button" aria-expanded="false" aria-controls="contactInfo">
            <strong>Contact Information</strong>
        </a>
    </div>
    <div class="collapse" id="contactInfo">
        <div class="card-body">

                <!-- Mobile and Phone Number -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="mobileNumber" class="form-label">Mobile Number</label>
                <input type="text" name="mobileNumber" class="form-control" placeholder="Enter Mobile Number">
            </div>
            <div class="col-md-6 mb-3">
                <label for="phoneNumber" class="form-label">Phone Number</label>
                <input type="text" name="phoneNumber" class="form-control" placeholder="Enter Phone Number">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label  for="personalEmail" class="form-label">Personal Email</label>
                <input type="text" name="personalEmail" class="form-control" placeholder="Personal Email">
            </div>
        </div>
        </div>
    </div>
</div>

<!-- Collapsible Adress  Section -->
 <div class="card mt-4">
    <div class="card-header">
        <a class="btn btn-link text-decoration-none" data-bs-toggle="collapse" href="#presentAddress" role="button" aria-expanded="false" aria-controls="contactInfo"><strong>Present Address</strong></a>
    </div>

    <div class="collapse" id="presentAddress">
        <div class="card-body">
            <!-- Address -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="addressLine1" class="form-label">Address Line 1</label>
                <input type="text" name="addressLine1" class="form-control" placeholder="Enter Address">
            </div>
            <div class="col-md-6 mb-3">
                <label for="addressLine2" class="form-label">Address Line 2</label>
                <input type="text" name="addressLine2" class="form-control" placeholder="Enter Additional Address">
            </div>
        </div>

        <!-- City, State, and Postal Code -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" name="city" class="form-control" placeholder="Enter City">
            </div>
            <div class="col-md-4 mb-3">
                <label for="state" class="form-label">State</label>
                <input type="text" name="state" class="form-control" placeholder="Enter State">
            </div>
            <div class="col-md-4 mb-3">
                <label for="postalCode" class="form-label">Postal Code</label>
                <input type="text" name="postalCode" class="form-control" placeholder="Enter Postal Code">
            </div>
        </div>
        </div>
    </div>

 </div>


 


 
 <div class="card mt-6">
                        <div class="card-header bg-primary text-white" >
                            <h4>Work Information</h4>
                            </div>
                            </div>

  <!-- Collapsible Job Information Section -->
  <div class="card mb-4">
        <div class="card-header">
            <a class="btn btn-link text-decoration-none" data-bs-toggle="collapse" href="#jobInformation" role="button" aria-expanded="false" aria-controls="jobInformation">
                <strong>Job Information</strong>
            </a>
        </div>
        <div class="collapse" id="jobInformation">
    <div class="card-body">
        <!-- Job Information Form -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="designation" class="form-label">Designation</label>
                <select class="form-control" id="designation">
                    <option>Select Designation</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="department" class="form-label">Department</label>
                <select class="form-control" id="department">
                    <option>Select Department</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="employmentType" class="form-label">Employment Type</label>
                <select class="form-control" id="employmentType">
                    <option>Select Employment Type</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="employmentLevel" class="form-label">Employment Level</label>
                <select class="form-control" id="employmentLevel">
                    <option>Select Employment Level</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="joinDate" class="form-label">Join Date *</label>
                <input type="date" class="form-control" id="joinDate">
            </div>
            <div class="col-md-6 mb-3">
                <label for="branch" class="form-label">Branch *</label>
                <select class="form-control" id="branch">
                    <option>Select Branch</option>
                    <option>Main Branch</option>
                </select>
            </div>
        </div>
        
        <!-- Fiscal Year Start Section -->
        <div class="row mb-3">
            <label class="form-label">Fiscal Year Start</label>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="fiscalStart" id="useDefaultFiscalDate" value="default" checked>
                    <label class="form-check-label" for="useDefaultFiscalDate">
                        Use Default Fiscal Date
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="fiscalStart" id="customFiscalDate" value="custom">
                    <label class="form-check-label" for="customFiscalDate">
                        Custom Fiscal Date
                    </label>
                </div>
            </div>
        </div>

        <!-- Custom Fiscal Date Fields (Initially Hidden) -->
        <div id="customFiscalFields" style="display: none;">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="fiscalMonth" class="form-label">Month</label>
                    <select class="form-control" id="fiscalMonth">
                        <option>Select Month</option>
                        <option>January</option>
                        <option>February</option>
                        <option>March</option>
                        <option>April</option>
                        <option>May</option>
                        <option>June</option>
                        <option>July</option>
                        <option>August</option>
                        <option>September</option>
                        <option>October</option>
                        <option>November</option>
                        <option>December</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="fiscalDay" class="form-label">Day</label>
                    <input type="number" class="form-control" id="fiscalDay" min="1" max="31">
                </div>
            </div>
        </div>

    </div>
</div>

    <!-- Collapsible Attendance Information Section -->
    <div class="card mb-4">
        <div class="card-header">
            <a class="btn btn-link text-decoration-none" data-bs-toggle="collapse" href="#attendanceInformation" role="button" aria-expanded="false" aria-controls="attendanceInformation">
                <strong>Attendance Information</strong>
            </a>
        </div>
        <div class="collapse" id="attendanceInformation">
            <div class="card-body">
                <!-- Attendance Information Form -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="attendanceShift" class="form-label">Attendance Shift</label>
                        <select class="form-control" id="attendanceShift">
                            <option>Select Attendance Shift</option>
                            <option>Mornind Shift</option>
                            <option>Night Shift</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="leavePolicy" class="form-label">Leave Policy</label>
                        <select class="form-control" id="leavePolicy">
                            <option>Select Leave Policy</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="holidayLists" class="form-label">Holiday Lists</label>
                        <select class="form-control" id="holidayLists">
                            <option>Select Holiday List</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="attendanceRestrictions" class="form-label">Attendance Restrictions</label>
                        <select class="form-control" id="attendanceRestrictions">
                            <option>Select Attendance Restriction</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>


                        <!-- Submit Button -->
                        <div class="row mt-4">
                            <div class="text-center">
                                <button type="submit" id="submitBtn" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>



<script>

    // JavaScript to toggle visibility of custom fiscal date fields
    document.getElementById('useDefaultFiscalDate').addEventListener('change', function() {
        document.getElementById('customFiscalFields').style.display = 'none';
    });

    document.getElementById('customFiscalDate').addEventListener('change', function() {
        document.getElementById('customFiscalFields').style.display = 'block';
    });


    document.addEventListener('DOMContentLoaded', function () {
        const allowAccessCheckbox = document.getElementById('allowAccess');
        const sendCredentialsSection = document.getElementById('sendCredentialsSection');
        const roleAndLanguageSection = document.getElementById('roleAndLanguageSection');

        // Initially hide both sections on page load
        sendCredentialsSection.style.display = 'none';
        roleAndLanguageSection.style.display = 'none';

        // Toggle visibility of sections based on "Allow access to the system" checkbox
        allowAccessCheckbox.addEventListener('change', function () {
            if (allowAccessCheckbox.checked) {
                roleAndLanguageSection.style.display = 'block'; // Show role and language section
                sendCredentialsSection.style.display = 'block'; // Show send credentials checkbox
            } else {
                roleAndLanguageSection.style.display = 'none'; // Hide role and language section
                sendCredentialsSection.style.display = 'none'; // Hide send credentials checkbox
            }
        });
    });

    // Get references to the form elements
const allowAccessCheckbox = document.getElementById('allowAccess');
const sendCredentialsSection = document.getElementById('sendCredentialsSection');
const roleAndLanguageSection = document.getElementById('roleAndLanguageSection');
const roleSelect = document.getElementById('role');
const submitButton = document.getElementById('submitBtn');
const sendCredentialsCheckbox = document.getElementById('sendCredentials');

// Add event listener to the "Allow access to the system" checkbox
allowAccessCheckbox.addEventListener('change', function() {
    // If checkbox is checked, show role selection and language section
    if (allowAccessCheckbox.checked) {
        roleAndLanguageSection.style.display = 'block';
        submitButton.disabled = false; // Enable submit button
        
        // Show send credentials checkbox
        sendCredentialsSection.style.display = 'block';
        
    } else {
        // If unchecked, hide role and language section, and send credentials checkbox
        roleAndLanguageSection.style.display = 'none';
        sendCredentialsSection.style.display = 'none';
        submitButton.disabled = true; // Disable submit button
    }
});

// Handle form submission (for demonstration purposes)
document.getElementById('addEmployeeForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent the form from submitting

    // Get references to the form elements
    const roleSelect = document.getElementById('role');
    const allowAccessCheckbox = document.getElementById('allowAccess');
    const sendCredentialsCheckbox = document.getElementById('sendCredentials');
    
    const role = roleSelect.value;
    const isManager = role === 'Manager';
    const hasAccess = allowAccessCheckbox.checked;
    const sendCredentials = sendCredentialsCheckbox.checked;

    // Check if "Allow access" checkbox is checked
    if (hasAccess) {
        // Determine the role and alert accordingly
        if (isManager) {
            alert("Manager role selected: Full ERP system access.");
        } else if (role === 'Employee') {
            alert("Employee role selected: Limited ERP system access.");
        } else {
            alert("Please select a valid role.");
            return;
        }

        // Handle send credentials logic
        if (sendCredentials) {
            alert("Credentials will be sent to the employee.");
        }
    } else {
        alert("No access to the ERP system.");
    }

    // You can proceed with form submission here (if needed for server-side processing)
    // For example, sending data via AJAX to the server or redirecting.
});


   

</script>








<?php include 'footer.php'; ?>
