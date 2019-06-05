<script type="text/javascript">

    Vue.component('ckeditora', {
  template: `<div class="ckeditor"><textarea :id="id" :value="value"></textarea></div>`,
  props: {
      value: {
        type: String
      },
      id: {
        type: String,
        default: 'editorD'
      },
      height: {
        type: String,
        default: '150px',
      },
      toolbar: {
        type: Array,
        default: () => [
          ['Undo','Redo'],
          ['Bold','Italic','Strike'],
          ['NumberedList','BulletedList'],
          ['Cut','Copy','Paste'],
        ]
      },
      language: {
        type: String,
        default: 'es'
      },
      extraplugins: {
        type: String,
        default: ''
      }
        },
        beforeUpdate () {
      const ckeditorId = this.id
      if (this.value !== CKEDITOR.instances[ckeditorId].getData()) {
        CKEDITOR.instances[ckeditorId].setData(this.value)
      }
        },
        mounted () {
      const ckeditorId = this.id
      //console.log(this.value)
      const ckeditorConfig = {
        toolbar: this.toolbar,
        language: this.language,
        height: this.height,
        extraPlugins: this.extraplugins
      }
      CKEDITOR.replace(ckeditorId, ckeditorConfig)
      CKEDITOR.instances[ckeditorId].setData(this.value)
      /*CKEDITOR.instances[ckeditorId].on('change', () => {
        let ckeditorData = CKEDITOR.instances[ckeditorId].getData()
        if (ckeditorData !== this.value) {
          this.$emit('input', ckeditorData)
        }
      })*/
        },
        destroyed () {
      const ckeditorId = this.id
      if (CKEDITOR.instances[ckeditorId]) {
        CKEDITOR.instances[ckeditorId].destroy()
      }
        }
  
});


    Vue.component('ckeditore', {
  template: `<div class="ckeditor"><textarea :id="idE" :value="value"></textarea></div>`,
  props: {
      value: {
        type: String
      },
      idE: {
        type: String,
        default: 'editorDM'
      },
      height: {
        type: String,
        default: '150px',
      },
      toolbar: {
        type: Array,
        default: () => [
          ['Undo','Redo'],
          ['Bold','Italic','Strike'],
          ['NumberedList','BulletedList'],
          ['Cut','Copy','Paste'],
        ]
      },
      language: {
        type: String,
        default: 'es'
      },
      extraplugins: {
        type: String,
        default: ''
      }
        },
        beforeUpdate () {
      const ckeditorId = this.idE
      if (this.value !== CKEDITOR.instances[ckeditorId].getData()) {
        CKEDITOR.instances[ckeditorId].setData(this.value)
      }
        },
        mounted () {
      const ckeditorId = this.idE
      //console.log(this.value)
      const ckeditorConfig = {
        toolbar: this.toolbar,
        language: this.language,
        height: this.height,
        extraPlugins: this.extraplugins
      }
      CKEDITOR.replace(ckeditorId, ckeditorConfig)
      CKEDITOR.instances[ckeditorId].setData(this.value)
      /*CKEDITOR.instances[ckeditorId].on('change', () => {
        let ckeditorData = CKEDITOR.instances[ckeditorId].getData()
        if (ckeditorData !== this.value) {
          this.$emit('input', ckeditorData)
        }
      })*/
        },
        destroyed () {
      const ckeditorId = this.idE
      if (CKEDITOR.instances[ckeditorId]) {
        CKEDITOR.instances[ckeditorId].destroy()
      }
        }
  
});





Vue.component('ckeditorm', {
  template: `<div class="ckeditor"><textarea :id="idModE" :value="value"></textarea></div>`,
  props: {
      value: {
        type: String
      },
      idModE: {
        type: String,
        default: 'editorMod'
      },
      height: {
        type: String,
        default: '150px',
      },
      toolbar: {
        type: Array,
        default: () => [
          ['Undo','Redo'],
          ['Bold','Italic','Strike'],
          ['NumberedList','BulletedList'],
          ['Cut','Copy','Paste'],
        ]
      },
      language: {
        type: String,
        default: 'es'
      },
      extraplugins: {
        type: String,
        default: ''
      }
        },
        beforeUpdate () {
      const ckeditorId = this.idModE
      if (this.value !== CKEDITOR.instances[ckeditorId].getData()) {
        CKEDITOR.instances[ckeditorId].setData(this.value)
      }
        },
        mounted () {
      const ckeditorId = this.idModE
      //console.log(this.value)
      const ckeditorConfig = {
        toolbar: this.toolbar,
        language: this.language,
        height: this.height,
        extraPlugins: this.extraplugins
      }
      CKEDITOR.replace(ckeditorId, ckeditorConfig)
      CKEDITOR.instances[ckeditorId].setData(this.value)
      /*CKEDITOR.instances[ckeditorId].on('change', () => {
        let ckeditorData = CKEDITOR.instances[ckeditorId].getData()
        if (ckeditorData !== this.value) {
          this.$emit('input', ckeditorData)
        }
      })*/
        },
        destroyed () {
      const ckeditorId = this.idModE
      if (CKEDITOR.instances[ckeditorId]) {
        CKEDITOR.instances[ckeditorId].destroy()
      }
        }
  
});





Vue.component('ckeditornm', {
  template: `<div class="ckeditor"><textarea :id="idModNE" :value="value"></textarea></div>`,
  props: {
      value: {
        type: String
      },
      idModNE: {
        type: String,
        default: 'editorNMod'
      },
      height: {
        type: String,
        default: '150px',
      },
      toolbar: {
        type: Array,
        default: () => [
          ['Undo','Redo'],
          ['Bold','Italic','Strike'],
          ['NumberedList','BulletedList'],
          ['Cut','Copy','Paste'],
        ]
      },
      language: {
        type: String,
        default: 'es'
      },
      extraplugins: {
        type: String,
        default: ''
      }
        },
        beforeUpdate () {
      const ckeditorId = this.idModNE
      if (this.value !== CKEDITOR.instances[ckeditorId].getData()) {
        CKEDITOR.instances[ckeditorId].setData(this.value)
      }
        },
        mounted () {
      const ckeditorId = this.idModNE
      //console.log(this.value)
      const ckeditorConfig = {
        toolbar: this.toolbar,
        language: this.language,
        height: this.height,
        extraPlugins: this.extraplugins
      }
      CKEDITOR.replace(ckeditorId, ckeditorConfig)
      CKEDITOR.instances[ckeditorId].setData(this.value)
      /*CKEDITOR.instances[ckeditorId].on('change', () => {
        let ckeditorData = CKEDITOR.instances[ckeditorId].getData()
        if (ckeditorData !== this.value) {
          this.$emit('input', ckeditorData)
        }
      })*/
        },
        destroyed () {
      const ckeditorId = this.idModNE
      if (CKEDITOR.instances[ckeditorId]) {
        CKEDITOR.instances[ckeditorId].destroy()
      }
        }
  
});









Vue.component('ckeditornr', {
  template: `<div class="ckeditor"><textarea :id="idModNR" :value="value"></textarea></div>`,
  props: {
      value: {
        type: String
      },
      idModNR: {
        type: String,
        default: 'editorNReg'
      },
      height: {
        type: String,
        default: '150px',
      },
      toolbar: {
        type: Array,
        default: () => [
          ['Undo','Redo'],
          ['Bold','Italic','Strike'],
          ['NumberedList','BulletedList'],
          ['Cut','Copy','Paste'],
        ]
      },
      language: {
        type: String,
        default: 'es'
      },
      extraplugins: {
        type: String,
        default: ''
      }
        },
        beforeUpdate () {
      const ckeditorId = this.idModNR
      if (this.value !== CKEDITOR.instances[ckeditorId].getData()) {
        CKEDITOR.instances[ckeditorId].setData(this.value)
      }
        },
        mounted () {
      const ckeditorId = this.idModNR
      //console.log(this.value)
      const ckeditorConfig = {
        toolbar: this.toolbar,
        language: this.language,
        height: this.height,
        extraPlugins: this.extraplugins
      }
      CKEDITOR.replace(ckeditorId, ckeditorConfig)
      CKEDITOR.instances[ckeditorId].setData(this.value)
      /*CKEDITOR.instances[ckeditorId].on('change', () => {
        let ckeditorData = CKEDITOR.instances[ckeditorId].getData()
        if (ckeditorData !== this.value) {
          this.$emit('input', ckeditorData)
        }
      })*/
        },
        destroyed () {
      const ckeditorId = this.idModNR
      if (CKEDITOR.instances[ckeditorId]) {
        CKEDITOR.instances[ckeditorId].destroy()
      }
        }
  
});







Vue.component('ckeditorer', {
  template: `<div class="ckeditor"><textarea :id="idModER" :value="value"></textarea></div>`,
  props: {
      value: {
        type: String
      },
      idModER: {
        type: String,
        default: 'editorEReg'
      },
      height: {
        type: String,
        default: '150px',
      },
      toolbar: {
        type: Array,
        default: () => [
          ['Undo','Redo'],
          ['Bold','Italic','Strike'],
          ['NumberedList','BulletedList'],
          ['Cut','Copy','Paste'],
        ]
      },
      language: {
        type: String,
        default: 'es'
      },
      extraplugins: {
        type: String,
        default: ''
      }
        },
        beforeUpdate () {
      const ckeditorId = this.idModER
      if (this.value !== CKEDITOR.instances[ckeditorId].getData()) {
        CKEDITOR.instances[ckeditorId].setData(this.value)
      }
        },
        mounted () {
      const ckeditorId = this.idModER
      //console.log(this.value)
      const ckeditorConfig = {
        toolbar: this.toolbar,
        language: this.language,
        height: this.height,
        extraPlugins: this.extraplugins
      }
      CKEDITOR.replace(ckeditorId, ckeditorConfig)
      CKEDITOR.instances[ckeditorId].setData(this.value)
      /*CKEDITOR.instances[ckeditorId].on('change', () => {
        let ckeditorData = CKEDITOR.instances[ckeditorId].getData()
        if (ckeditorData !== this.value) {
          this.$emit('input', ckeditorData)
        }
      })*/
        },
        destroyed () {
      const ckeditorId = this.idModER
      if (CKEDITOR.instances[ckeditorId]) {
        CKEDITOR.instances[ckeditorId].destroy()
      }
        }
  
});


</script>