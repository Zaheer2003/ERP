function showForm(formType) {
        if (formType === 'individual') {
            document.getElementById('individual-form').style.display = 'block';
            document.getElementById('business-form').style.display = 'none';
        } else if (formType === 'business') {
            document.getElementById('individual-form').style.display = 'none';
            document.getElementById('business-form').style.display = 'block';
        }
 