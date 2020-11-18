Nova.booting((Vue, router, store) => {
  Vue.component('index-payments-hook', require('./components/IndexField'))
  Vue.component('detail-payments-hook', require('./components/DetailField'))
  Vue.component('form-payments-hook', require('./components/FormField'))
})
