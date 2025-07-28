const editUserModal = document.getElementById('editUserModal');
if (editUserModal) {
    editUserModal.addEventListener('show.bs.modal', (event) => {
        const button = event.relatedTarget;

        const userID = button.getAttribute('data-bs-user-id');
        const userRole = button.getAttribute('data-bs-user-role');
        const modalTitle = editUserModal.querySelector('.modal-title');
        const userIDInput = editUserModal.querySelector('#userID');
        const userRoleInput = editUserModal.querySelector('#userRole');

        modalTitle.textContent = `Update User Role for User ID ${userID}`;
        userIDInput.value = userID;
        userRoleInput.value = userRole;
    });
}