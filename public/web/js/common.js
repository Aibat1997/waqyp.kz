$('.dropcollap').click(function () {
    $('.in-menu').css('display', 'none');
    $(this).find('.in-menu').slideToggle(100);
});
$('.ic-menu').click(function () {
    $('.mob-menu').css('display', 'none');
    $('.mob-menu').slideToggle(100);
});
var Pay = {
    send: function (self) {
        var input = parseInt(self.closest('.item-box').find('input[name=money]').val());
        if (isNaN(input)) {
            return Pay.notify("error", "Введите сумму");
        } else if (1000 > input) {
            return Pay.notify("info", "Минимальная сумма 1000");
        }
        window.location.href = "/pay?sum=" + input;
    },
    notify: function (className, text) {
        Toastify({
            text: text,
            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
            className: className,
        }).showToast();
    }
}