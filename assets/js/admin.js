/**
 * Admin-specific JavaScript functionality
 * 
 * Handles admin panel interactions and form validations
 * 
 * @package ShoeStore
 * @subpackage Admin
 */

document.addEventListener('DOMContentLoaded', function() {
    // Image preview for product upload
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    
    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.addEventListener('load', function() {
                    imagePreview.src = this.result;
                    imagePreview.style.display = 'block';
                });
                
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Form validations
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let valid = true;
            
            // Validate required fields
            const requiredInputs = this.querySelectorAll('[required]');
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('error');
                    valid = false;
                } else {
                    input.classList.remove('error');
                }
            });
            
            // Validate numeric fields
            const numericInputs = this.querySelectorAll('input[type="number"]');
            numericInputs.forEach(input => {
                if (isNaN(input.value) || input.value < 0) {
                    input.classList.add('error');
                    valid = false;
                } else {
                    input.classList.remove('error');
                }
            });
            
            // Validate file uploads
            const fileInputs = this.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                if (input.required && input.files.length === 0) {
                    input.classList.add('error');
                    valid = false;
                } else {
                    input.classList.remove('error');
                }
            });
            
            if (!valid) {
                e.preventDefault();
                alert('Please fill out all required fields correctly.');
            }
        });
    });
    
    // Confirmation for delete actions
    const deleteButtons = document.querySelectorAll('.btn.danger');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this item?')) {
                e.preventDefault();
            }
        });
    });
    
    // Toggle form panels
    const toggleButtons = document.querySelectorAll('.toggle-form');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetForm = document.getElementById(targetId);
            
            if (targetForm) {
                targetForm.classList.toggle('hidden');
                this.textContent = targetForm.classList.contains('hidden') ? 
                    'Show Form' : 'Hide Form';
            }
        });
    });
});