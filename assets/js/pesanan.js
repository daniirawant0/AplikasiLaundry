// =============================================
// PESANAN JS — Service Pill Picker
// =============================================

function pickService(value, el) {
    document.querySelectorAll('.service-pill').forEach(p => p.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('layanan').value = value;
}
