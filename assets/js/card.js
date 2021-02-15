import axios from "axios";

const rangeCard = document.querySelector('#rangeCard');

if (rangeCard) {
    rangeCard.addEventListener("change", function (e) {
        axios.post('/data/transactions', {
            'card_id': this.dataset.id,
            'value': this.value
        })
            .then(function (response) {
                console.log(response.data);
            })
        ;
    });
}