document.addEventListener('DOMContentLoaded', function() {
    // Modal elements
    const modal = document.getElementById('modifyModal');
    const modifyButtons = document.querySelectorAll('.modify-btn');
    const closeBtn = document.querySelector('.btn-close.close');
    const cancelBtn = document.getElementById('cancelBtn');
    const modifyForm = document.getElementById('modifyForm');
    const categoryNameInput = document.getElementById('categoryNameInput');
    
    // Bootstrap modal instance (using native JS)
    const bsModal = new bootstrap.Modal(modal);
    
    // Open modal when modify button is clicked
    modifyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.label;
            
            // Set form action
            modifyForm.action = `/categories/${id}`;
            
            // Fill input with current name
            categoryNameInput.value = name;
            
            // Show modal
            bsModal.show();
        });
    });
    
    // Close modal handlers
    closeBtn.addEventListener('click', () => bsModal.hide());
    cancelBtn.addEventListener('click', () => bsModal.hide());
})