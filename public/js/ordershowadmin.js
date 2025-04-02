document.addEventListener('DOMContentLoaded', function(){
    const showbtn = document.querySelectorAll('.show-btn');
    const modal = document.getElementById('ShowModal');
    const modalheader = document.querySelector('.mhead');
    const modalbody = document.querySelector('.mbody');
    const cancelBtn = document.getElementById('cancelBtn');

    const bsModal = new bootstrap.Modal(modal);

    showbtn.forEach(button => {
        button.addEventListener('click', function(){
            const order = JSON.parse(this.getAttribute('data-order'));
            const carts = JSON.parse(this.getAttribute('data-cart'));
            modalheader.innerHTML = `
                <h5 class="modal-title">Order #${order.id} for ${order.user.fullname}</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal"></button>
            `;

            console.log(carts);
            console.log(order);
            
            

            modalbody.innerHTML = `
                <div class="container-fluid">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Order Information</h6>
                            <p><strong>Customer:</strong> ${order.user.fullname}</p>
                            <p><strong>Shipping Address:</strong> ${order.shipping_address}</p>
                            <p><strong>Status:</strong> ${order.status}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Payment Details</h6>
                            <p><strong>Total Price:</strong> ${order.total_price} dh</p>
                            <p><strong>Payment Method:</strong> ${order.payment_methode}</p>
                            <p><strong>Order Date:</strong> ${new Date(order.created_at).toLocaleString()}</p>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <h6>Details<h6>
                    </div>
                    <div class="row">
                        <table class="table table-responsive"> 
                            <tr class="">
                                <th scope="col" class="table-active text-center">image</th>
                                <th scope="col" class="table-active text-center">name</th>
                                <th scope="col" class="table-active text-center">description</th>
                                <th scope="col" class="table-active text-center">quantity</th>
                                <th scope="col" class="table-active text-center">total price</th>
                            </tr>
                            ${carts.map(
                                cart =>`
                                    <tr class="tablebody">
                                        <td scope="row" class="text-center">
                                            <img src="${cart.product.image}" width="50" height="50" alt = "" placeholder = "${cart.product.name}">
                                        </td>
                                        <td scope="row" class="text-center">${cart.product.name}</td>
                                        <td scope="row" class="text-center">${cart.product.description.substring(0, 50)}...</td>
                                        <td scope="row" class="text-center">${cart.q_bought}</td>
                                        <td scope="row" class="text-center">${cart.t_price}</td>
                                    </tr>
                                `
                            ).join('')}
                                
                        </table>
                    </div>
                </div>
            `;
            bsModal.show();
        });
    });
    cancelBtn.addEventListener('click', () => bsModal.hide());

});