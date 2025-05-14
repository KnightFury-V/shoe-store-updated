document.addEventListener('DOMContentLoaded', function(){

    // Toggle mobile nav (if you add a burger button)
    const toggleBtn = document.querySelector('#nav-toggle');
    const nav = document.querySelector('.navbar');
    if(toggleBtn){
      toggleBtn.addEventListener('click', () => {
        nav.classList.toggle('open');
      });
    }
  
    // Add‑to‑Cart buttons (enhance with AJAX or simple redirect)
    document.querySelectorAll('.add-to-cart').forEach(btn => {
      btn.addEventListener('click', function(e){
        e.preventDefault();
        const pid = this.dataset.productId;
        // Simple: redirect to cart.php?add=PID
        window.location.href = `cart.php?add=${pid}`;
      });
    });
  
    // Confirm deletion in admin lists
    document.querySelectorAll('.confirm-delete').forEach(link => {
      link.addEventListener('click', function(){
        return confirm('Are you sure you want to delete this item?');
      });
    });
  
  });
  