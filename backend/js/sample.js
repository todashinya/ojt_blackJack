function openModal() {
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modal');
        const openBtn = document.getElementById('playBtn');
        const closeBtn = document.querySelector('.modal__close');
    
        // ボタンクリック時にモーダルを表示
        openBtn.addEventListener('click', function(e) {
            e.preventDefault();
            copyInputValue();
            modal.style.display = 'block';
        });
    
        // モーダル内の閉じるボタンクリック時にモーダルを非表示
        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            modal.style.display = 'none';
        });
    
        // モーダル外をクリックした場合にモーダルを非表示
        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
}
openModal();


function copyInputValue() {
    const playerNameInput = document.getElementsByName("name")[0].value;
    const hiddenNameInput = document.getElementsByName("name")[1];
    hiddenNameInput.value = playerNameInput;
}