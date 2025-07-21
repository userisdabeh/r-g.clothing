const editPersonalForm = document.querySelector('.personal-form');
const editPersonalButton = document.querySelector('#edit-personal-button');
const saveChangesButton = document.querySelector('#save-changes');
const cancelChangesButton = document.querySelector('#cancel-changes');

editPersonalButton.addEventListener('click', () => {
    saveChangesButton.classList.remove('d-none');
    cancelChangesButton.classList.remove('d-none');
    
    const inputs = editPersonalForm.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.removeAttribute('disabled');
    });
});

cancelChangesButton.addEventListener('click', () => {
    saveChangesButton.classList.add('d-none');
    cancelChangesButton.classList.add('d-none');
    window.location.reload();
});

editPersonalForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const firstName = document.querySelector('#first_name').value;
    const lastName = document.querySelector('#last_name').value;
    const email = document.querySelector('#email').value;
    const phone = document.querySelector('#phone').value;
    const bio = document.querySelector('#bio').value;
    const region = document.querySelector('#region').value;
    const province = document.querySelector('#province').value;
    const city = document.querySelector('#city').value;
    const barangay = document.querySelector('#barangay').value;
    const zipCode = document.querySelector('#zip_code').value;

    console.log(firstName, lastName, email, phone, bio, region, province, city, barangay, zipCode);

    if (firstName === '' || lastName === '' || email === '' || phone === '' || bio === '' || region === '' || province === '' || city === '' || barangay === '' || zipCode === '') {
        alert('Please fill in all fields');
        return;
    }

    editPersonalForm.submit();
});
