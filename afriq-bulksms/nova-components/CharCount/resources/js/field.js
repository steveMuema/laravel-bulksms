import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-char-count', IndexField)
  app.component('detail-char-count', DetailField)
  app.component('form-char-count', FormField)
})
