document.addEventListener('DOMContentLoaded', function() {
    const optionsContainer = document.querySelector('.custom-select .options-container');
    const selectedOption = document.querySelector('.custom-select .selected');

    // Show options when the selected area is clicked
    selectedOption.addEventListener('click', function() {
        optionsContainer.classList.toggle('active');
    });

    // Assign selected role value and hide options when an option is clicked
    optionsContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('option')) {
            const selectedValue = event.target.getAttribute('data-value');
            selectedOption.textContent = selectedValue;
            optionsContainer.classList.remove('active');
        }
    });

    // Hide options when clicking outside the select box
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.custom-select')) {
            optionsContainer.classList.remove('active');
        }
    });
});

document.getElementById('loginForm').addEventListener('submit', function(event) {
    var username = document.getElementById('username').value;
    var role = document.querySelector('[name="role"]').value;
    
    // Jika username tidak diisi
    if (username.trim() === '') {
        event.preventDefault(); // Mencegah pengiriman formulir
        document.getElementById('error-message').textContent = 'Username cannot be empty.';
    }
});