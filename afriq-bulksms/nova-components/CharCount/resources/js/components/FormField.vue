<template>
  <DefaultField
    :field="field"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>    
      <textarea
        :id="field.attribute"
        class="block w-full form-control form-input form-input-bordered py-3 h-auto"
        :class="errorClasses"
        :placeholder="field.name"
        :max="maxLength"
        v-model="value"
        :rows="4"
      ></textarea>
      <p class="my-2 text-light">
       {{(value.length) }} characters. {{ ((value.length/maxLength)| 0) + 1 }} message(s) 
      </p>
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  data() {
    return {
      maxLength: 140,
    }
  },
  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || ''
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, this.value || '')
    },
  },
}
</script>
