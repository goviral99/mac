! function() {
    if ($(".i_type_list label").click((function(e) {
            var t = $(this).attr("data-img-url"),
                n = $(this).attr("data-text");
            $(".mainFormImg").css({
                background: 'url("' + t + '")'
            }), $(".mainImg_txt_wrap .mainImg_txt").text(n)
        })), $(".g_opts_inner:not(.opts_rand) input").on("change", (function(e) {
            e.preventDefault(), 0 == $(this).val() ? ($(".sel_val_amount").text(""), $(".otherVal").slideDown()) : ($(".otherVal").slideUp(), $('input[name="p_opts_other"]').val(""), $(".sel_val_amount").text("$" + $(this).val()))
        })), $('input[name="extra_gift"]').on("change", (function(e) {
            e.preventDefault();
            var t = $('input[name="total_payment"]').val();
            $(this).is(":checked") ? t = parseInt(t) + 10 : t -= 10, $('input[name="total_payment"]').val(t), $(".total_val").text(t)
        })), $('input[name="app_fee"]').on("change", (function(e) {
            e.preventDefault();
            var t = $('input[name="selected_payment"]').val(),
                n = $('input[name="total_payment"]').val(),
                a = parseInt(t),
                r = (n = parseInt(n), a / 100 * 2.9);
            a = Math.ceil(r + .3), $(this).is(":checked") ? n += a : n -= a, $('input[name="total_payment"]').val(n), $(".total_val").text(n)
        })), $("#payment_form").length > 0) {
        var e, t = Stripe("pk_live_51KrzE2BwNF8aAhcXYHWtGJ2c96GwbiIckgl2TBv5z21R2Jt5kkSPObbx5zfCLVR079QjrSQJyA09pSSsGXWCw6Qr00kvn0wEy6"),
            n = t.elements(),
            a = {
                base: {
                    color: "#32325d",
                    lineHeight: "44px",
                    fontSmoothing: "antialiased",
                    iconColor: "transparent",
                    fontSize: "16px",
                    "::placeholder": {
                        color: "#121942"
                    }
                },
                invalid: {
                    color: "#fa755a",
                    iconColor: "transparent"
                }
            };
        (e = n.create("cardNumber", {
            style: a
        })).mount("#co_cn"), i(e, "co_cn_response"), (e = n.create("cardExpiry", {
            style: a
        })).mount("#co_my"), i(e, "co_my_response"), (e = n.create("cardCvc", {
            style: a
        })).mount("#co_cw"), i(e, "co_cw_response");
        var r = {
            style: a,
            supportedCountries: ["SEPA"],
            placeholderCountry: "US"
        };
        n.create("iban", r);
        $(".StripeElement iframe, .__PrivateStripeElement").removeAttr("style");
        var o = document.getElementById("payment_form");
        $("input[name='p_type']").val();
        o.addEventListener("submit", (function(n) {
            if ("cc" == $('input[name="p_type"]:checked').val()) event.preventDefault(), t.createToken(e).then((function(e) {
                var t, n, a = document.getElementById("paymentError");
                if (e.error) a.innerHTML = '<p class="mb-0 mt-1" style="color:red">' + event.error.message + "</p>";
                else {
                    a.innerHTML = "";
                    var r = !0;
                    $("#payment_form input[required]").on("invalid", (function(e) {
                        r = !1
                    })), 1 == r && ($(".submit_Form").text("Processing"), $(".submit_Form").attr("disabled", "disabled"), $(".submit_Form").css({
                        background: "#8080804a",
                        color: "#121942"
                    })), t = e.token, (n = document.createElement("input")).setAttribute("type", "hidden"), n.setAttribute("name", "stripeToken"), n.setAttribute("value", t.id), o.appendChild(n), o.submit()
                }
            }));
            else {
                var a = !0;
                $("#payment_form input[required]").on("invalid", (function(e) {
                    a = !1
                })), 1 == a && ($(".submit_Form").text("Processing"), $(".submit_Form").attr("disabled", "disabled"), $(".submit_Form").css({
                    background: "#8080804a",
                    color: "#121942"
                }))
            }
        }));
        document.getElementById("payment-form"), document.getElementById("accountholder-name"), document.getElementById("email");

        function i(e, t) {
            t = document.getElementById(t);
            e.addEventListener("change", (function(e) {
                e.error ? t.innerHTML = '<p class="mb-0 mt-1" style="color:red">' + e.error.message + "</p>" : t.innerHTML = ""
            }))
        }
    }
}();