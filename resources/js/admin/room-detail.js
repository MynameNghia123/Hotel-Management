document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('addServiceModal');
    const btnOpenList = document.querySelectorAll('.rd-add-serv-btn');
    const btnClose = document.getElementById('closeServiceModal');
    const btnCancel = document.getElementById('cancelServiceModal');

    // Open Modal
    btnOpenList.forEach(btn => {
        btn.addEventListener('click', () => {
            modal.classList.add('active');
        });
    });

    // Close Modal
    const closeModal = () => {
        modal.classList.remove('active');
    };

    if (btnClose) btnClose.addEventListener('click', closeModal);
    if (btnCancel) btnCancel.addEventListener('click', closeModal);

    // Bấm ra ngoài (overlay) để tắt
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Xử lý bộ đếm + / -
    const steppers = document.querySelectorAll('.rd-serv-stepper');
    steppers.forEach(stepper => {
        const btnDown = stepper.querySelector('.btn-down');
        const btnUp = stepper.querySelector('.btn-up');
        const spanVal = stepper.querySelector('.rd-serv-step-val');

        btnDown.addEventListener('click', () => {
            let val = parseInt(spanVal.innerText);
            if (val > 0) {
                val--;
                spanVal.innerText = val;
            }
        });

        btnUp.addEventListener('click', () => {
            let val = parseInt(spanVal.innerText);
            val++;
            spanVal.innerText = val;
        });
    });

    // ================= Xử lý Checkout Success ================= //
    const btnCheckout = document.querySelector('.rd-btn-checkout');
    const modalSuccess = document.getElementById('checkoutSuccessModal');

    if (btnCheckout && modalSuccess) {
        btnCheckout.addEventListener('click', () => {
            modalSuccess.classList.add('active');
            
            // Nếu muốn làm animation bắn pháo hoa confetti, có thể thêm sau =)) 
        });
    }

});
