// kategori.js
function editCategory(id) {
    // Tüm inputları ve düğmeleri kapat
    document.querySelectorAll('input[id^="input-"]').forEach(input => input.disabled = true);
    document.querySelectorAll('button[id^="save-"]').forEach(button => button.style.display = 'none');
    document.querySelectorAll('button[id^="edit-"]').forEach(button => button.style.display = 'inline');

    // Seçili olan inputu aç ve ilgili düğmeleri göster
    document.getElementById('input-' + id).disabled = false;
    document.getElementById('save-' + id).style.display = 'inline';
    document.getElementById('edit-' + id).style.display = 'none';
}

function saveCategory(id) {
    // Formu gönder
    document.getElementById('form-' + id).submit();
}
