document.addEventListener('DOMContentLoaded', function() {
    // Modal Elements
    const productModal = document.getElementById('productModal');
    const bsModal = new bootstrap.Modal(productModal);
    
    // Form Elements
    const productForm = document.getElementById('productForm');
    const modalTitle = document.getElementById('modalTitle');
    const formMethod = document.getElementById('formMethod');
    const productIdInput = document.getElementById('productId');
    
    // Buttons
    const addButtons = document.querySelectorAll('.add-btn'); // Add Product buttons
    const modifyButtons = document.querySelectorAll('.modify-btn'); // Modify Product buttons
    const closeBtn = productModal.querySelector('.btn-close');
    const cancelBtn = document.getElementById('cancelBtn');

    // **1. Handle "Add Product" Button Click**
    addButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Reset form and set up for "Add" mode
            resetForm();
            
            modalTitle.textContent = 'Add New Product';
            productForm.setAttribute('action', '/products'); // POST route
            formMethod.value = 'POST';
            
            bsModal.show();
        });
    });

    // **2. Handle "Modify Product" Button Click**
    modifyButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Reset form and set up for "Modify" mode
            resetForm();
            
            modalTitle.textContent = 'Edit Product';
            const productId = this.dataset.id;
            
            productForm.setAttribute('action', `/products/${productId}`); // PUT route
            formMethod.value = 'PUT';
            productIdInput.value = productId;
            
            // Fill form with existing data
            document.getElementById('productName').value = this.dataset.name;
            document.getElementById('productDescription').value = this.dataset.description;
            document.getElementById('productPrice').value = this.dataset.price;
            document.getElementById('productQuantity').value = this.dataset.quantity;
            document.getElementById('productCategory').value = this.dataset.category;
            
            // Display image preview if available
            if (this.dataset.image) {
                const preview = document.getElementById('imagePreview');
                preview.src = this.dataset.image;
                document.getElementById('imagePreviewContainer').style.display = 'block';
            }
            
            bsModal.show();
        });
    });

    // **3. Image Preview Functionality**
    document.getElementById('productImage').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                preview.src = e.target.result;
                document.getElementById('imagePreviewContainer').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // **4. Close Modal Handlers**
    closeBtn.addEventListener('click', () => bsModal.hide());
    cancelBtn.addEventListener('click', () => bsModal.hide());
    
    // **5. Reset Form When Modal Closes**
    productModal.addEventListener('hidden.bs.modal', resetForm);

    // **Helper Function: Reset Form**
    function resetForm() {
        productForm.reset();
        document.getElementById('imagePreviewContainer').style.display = 'none';
        document.getElementById('productImage').value = ''; // Clear file input
    }
});