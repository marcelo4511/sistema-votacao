import Vue from 'vue'
import moment from 'moment';

let formatDate = Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
    }
});

export default formatDate