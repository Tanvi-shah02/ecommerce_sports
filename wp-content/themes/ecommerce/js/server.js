async function createServerPayment(payload) {
    try {


        const idempotency_key = payload['idempotencyKey'] || makeid(15);

        const payment = {
            idempotency_key,
            location_id: payload['locationId'],
            source_id: payload['sourceId'],

            amount_money: {
                amount: payload['amount'],

                currency: 'CAD',
            },
        };

        if (payload.customerId) {
            payment.customerId = payload.customerId;
        }


        if (payload.verificationToken) {
            payment.verificationToken = payload.verificationToken;
        }

        var myHeaders = new Headers();

        myHeaders.append("Content-Type", "application/json");
        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: JSON.stringify(payment),

        };


        const response = await fetch('https://lvlupsoccerregistration.com/square-sdk/', requestOptions);
        const result = await response.json();

        return(result);

    } catch (ex) {
        console.log(ex);
    }

}

function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}