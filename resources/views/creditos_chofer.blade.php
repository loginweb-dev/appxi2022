@extends('master')


@section('content')
    <h4>Créditos</h4>

@endsection

@section('javascript')

    <script>

        async function GeneralLinkBanipay(concepto,cantidad, precio) {
            var micart2 = []

            micart2.push({"concept": concepto, "quantity": cantidad, "unitPrice": precio})

            var miconfig = {"affiliateCode": "{{ setting('banipay.affiliatecode') }}",
                "notificationUrl": "{{ setting('banipay.notificacion') }}",//vistaurl
                "withInvoice": false,
                "externalCode": null,//credito_id
                "paymentDescription": "Pago por la compra en {{ setting('admin.title') }}",
                "details": micart2,
                "postalCode": "{{ setting('banipay.moneda') }}"
                }
            var banipay = await axios.post('https://banipay.me:8443/api/payments/transaction', miconfig)

            return banipay.data;

        }
    </script>

@endsection
