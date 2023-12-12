+function ($) {
    "use strict"

    var ProcessSumup = function (element, options) {
        this.$el = $(element)
        this.options = options || {}
        this.$checkoutForm = this.$el.closest('#checkout-form')
        this.sumup = null
        this.card = null

        $('[name=payment][value=sumup]', this.$checkoutForm).on('change', $.proxy(this.init, this))
    }

    ProcessSumup.DEFAULTS = {
        publicKey: undefined,
        paymentIntentSecret: undefined,
        sumupOptions: undefined,
        partnerId: 'pp_partner_JZyCCGR3cOwj9S',
        cardSelector: '#sumup-card-element',
        errorSelector: '#sumup-card-errors',
    }

    ProcessSumup.prototype.init = function () {
        if (this.sumup !== null || !$(this.options.cardSelector).length)
            return

        if (this.options.publicKey === undefined)
            throw new Error('Missing sumup public key')

        // Create a Sumup client.
        this.sumup = Sumup(this.options.publicKey, this.options.sumupOptions)

        // Used by Sumup to identify this integration
        this.sumup.registerAppInfo({
            name: "TastyIgniter Sumup",
            partner_id: this.options.partnerId,  // Used by Sumup to identify this integration
            url: 'https://tastyigniter.com/marketplace/item/igniter-payregister'
        });

        // Create an instance of the card Element.
        this.card = this.sumup.elements().create('card')

        // Add an instance of the card Element into the `card-element` <div>.
        this.card.mount(this.options.cardSelector);

        // Handle real-time validation errors from the card Element.
        this.card.addEventListener('change', $.proxy(this.validationErrorHandler, this))

        this.$checkoutForm.on('submitCheckoutForm', $.proxy(this.submitFormHandler, this))

        var self = this
        this.$checkoutForm.on('submit', function () {
            if (self.$checkoutForm.find('input[name="payment"]:checked').val() !== 'sumup')
                return

            self.card.update({disabled: true});
        })

        this.$checkoutForm.on('ajaxFail', function () {
            self.card.update({disabled: false});
        })
    }

    ProcessSumup.prototype.validationErrorHandler = function (event) {
        var $el = this.$checkoutForm.find(this.options.errorSelector)
        if (event.error) {
            $el.html(event.error.message);
        } else {
            $el.empty();
        }

        $('.checkout-btn').prop('disabled', false)
        this.card.update({disabled: false});
    }

    ProcessSumup.prototype.submitFormHandler = function (event) {
        var self = this,
            $form = this.$checkoutForm,
            $paymentInput = $form.find('input[name="payment"]:checked')

        if ($paymentInput.val() !== 'sumup') return

        // Prevent the form from submitting with the default action
        event.preventDefault()

        this.sumup.confirmCardPayment(this.options.paymentIntentSecret, {
            payment_method: {
                card: this.card,
                billing_details: {
                    name: $form.find('input[name="first_name"]').val()+' '+$form.find('input[name="last_name"]').val()
                }
            },
            receipt_email: $form.find('input[name="email"]').val(),
        }).then(function (result) {
            var paymentIntentStatus = (result.error && result.error.payment_intent)
                ? result.error.payment_intent.status : null

            if (result.error && !(paymentIntentStatus === 'requires_capture' || paymentIntentStatus === 'succeeded')) {
                // Inform the user if there was an error.
                self.validationErrorHandler(result)
            } else {
                // Switch back to default to submit form
                $form.unbind('submitCheckoutForm').submit()
            }
        });
    }

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.processSumup

    $.fn.processSumup = function (option) {
        var $this = $(this).first()
        var options = $.extend(true, {}, ProcessSumup.DEFAULTS, $this.data(), typeof option == 'object' && option)

        return new ProcessSumup($this, options)
    }

    $.fn.processSumup.Constructor = ProcessSumup

    $.fn.processSumup.noConflict = function () {
        $.fn.processSumup = old
        return this
    }

    $(document).render(function () {
        $('#sumupPaymentForm').processSumup()
    })
}(window.jQuery)
