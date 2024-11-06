// JavaScript to handle button clicks and set hidden input values
const userButtons = document.querySelectorAll('.user-button');
const bookButtons = document.querySelectorAll('.book-button');
const selectedUserIdInput = document.getElementById('selected-user-id');
const selectedBookIdInput = document.getElementById('selected-book-id');

userButtons.forEach(button => {
    button.addEventListener('click', () => {
        const isSelected = button.classList.contains('clicked-button');

        // Deselect all user buttons
        userButtons.forEach(btn => btn.classList.remove('clicked-button'));

        if (!isSelected) {
            // Toggle the .clicked-button class for the clicked button
            button.classList.add('clicked-button');
            selectedUserIdInput.value = button.getAttribute('data-user-id');
        } else {
            // If already selected, remove the selection
            selectedUserIdInput.value = ''; // Clear the selected user ID
        }
    });
});

    bookButtons.forEach(button => {
    button.addEventListener('click', () => {
        const isSelected = button.classList.contains('clicked-button');

        // Deselect all book buttons
        bookButtons.forEach(btn => btn.classList.remove('clicked-button'));

        if (!isSelected) {
            // Toggle the .clicked-button class for the clicked button
            button.classList.add('clicked-button');
            selectedBookIdInput.value = button.getAttribute('data-book-id');
        } else {
            // If already selected, remove the selection
            selectedBookIdInput.value = ''; // Clear the selected book ID
        }
    });
});
