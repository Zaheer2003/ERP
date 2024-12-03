<?php include('Header.php'); ?>



<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Account Setting</h3>
                </div>
                <div class="card-body">
                    <!-- Buttons for Email Change, Password Change, and Save Changes -->
                    <div class="d-flex justify-content-between">
                        <!-- Email Change Button -->
                        <button class="btn btn-primary" id="changeEmailBtn">Change Email</button>

                        <!-- Password Change Button (Triggers the Modal) -->
                        <button class="btn btn-warning" id="changePasswordBtn" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</button>

                        <!-- Save Button -->
                        <button class="btn btn-success" id="saveChangesBtn">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Password Change -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="changePasswordForm">
          <div class="mb-3">
            <label for="currentPassword" class="form-label">Current Password</label>
            <input type="password" class="form-control" id="currentPassword" required>
          </div>
          <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <input type="password" class="form-control" id="newPassword" required>
          </div>
          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="confirmPasswordChangeBtn">Confirm</button>
      </div>
    </div>
  </div>
</div>




<div class="container mt-4">
    <div class="row">
        <!-- Left Side Form -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Business Details</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="businessName" class="form-label">Business Name</label>
                            <input type="text" class="form-control" id="businessName" value="Ruby" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" value="Mohamed" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" value="Zaheer" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="text" class="form-control" id="mobile" value="+94758511400" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="telephone" class="form-label">Telephone</label>
                            <input type="text" class="form-control" id="telephone" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="address1" class="form-label">Street Address 1</label>
                            <input type="text" class="form-control" id="address1" value="117/1 Penthanigoda" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="address2" class="form-label">Street Address 2</label>
                            <input type="text" class="form-control" id="address2" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" value="Narammala" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" value="North Western" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="postalCode" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="postalCode" value="60100" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country" value="Sri Lanka (LK)" disabled>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Side Form -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Account Settings</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="currency" class="form-label">Currency</label>
                            <input type="text" class="form-control" id="currency" value="LKR Sri Lankan Rupee" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="timeZone" class="form-label">Time Zone</label>
                            <input type="text" class="form-control" id="timeZone" value="(UTC-01:00) Azores" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="currencyFormat" class="form-label">Negative Currency Formats</label>
                            <input type="text" class="form-control" id="currencyFormat" value="-Rs. 19.66" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="dateFormat" class="form-label">Date Format</label>
                            <input type="text" class="form-control" id="dateFormat" value="dd/mm/yyyy (02/12/2024)" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="language" class="form-label">Language</label>
                            <input type="text" class="form-control" id="language" value="English (EN)" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="youSell" class="form-label">You Sell</label>
                            <input type="text" class="form-control" id="youSell" value="Services Only" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="printingMethod" class="form-label">Printing Method</label>
                            <input type="text" class="form-control" id="printingMethod" value="Browser" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo</label>
                            <input type="file" class="form-control" id="logo" disabled>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('confirmPasswordChangeBtn').addEventListener('click', function() {
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    // Validate passwords
    if (newPassword !== confirmPassword) {
        alert("New password and confirm password don't match!");
        return;
    }

    if (newPassword.length < 6) {
        alert("Password must be at least 6 characters long.");
        return;
    }

    // Send the data to the server
    fetch('/update-password', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            currentPassword: currentPassword,
            newPassword: newPassword,
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Password updated successfully!');
            // Close the modal
            var modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
            modal.hide();
        } else {
            alert(data.message || 'Error updating password!');
        }
    })
    .catch(error => {
        alert('There was an error processing your request.');
        console.error(error);
    });
});

</script>



<?php include('Footer.php'); ?>
