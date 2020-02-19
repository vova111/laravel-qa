<template>
  <div class="row mt-4">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">
            <h3>Your Answer</h3>
          </div>
          <hr>
          <form>
            <div class="form-group">
              <m-editor :body="body" name="new-answer">
                <textarea class="form-control" rows="7" required v-model="body" name="body"></textarea>
              </m-editor>
            </div>
            <div class="form-group">
              <button type="button" @click="create" :disabled="isInvalid" class="btn btn-lg btn-outline-primary">
                <spinner :small="true" v-if="$root.loading"></spinner>
                <span v-else>Submit</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
  import MEditor from './MEditor';

  export default {
    components: {
      MEditor,
    },
    props: ['questionId'],
    data () {
      return {
        body: '',
      };
    },
    computed: {
      isInvalid () {
        return !this.singedIn || this.body.length < 10;
      },
    },
    methods: {
      create () {
        axios.post(`/questions/${this.questionId}/answers`, { body: this.body })
          .then(({ data }) => {
            this.$toast.success(data.message, "Success", {});
            this.body = '';
            this.$emit('created', data.answer);
          })
          .catch(error => {
            this.$toast.error(error.response.data.message, "Error", {});
          });
      },
    },
  };
</script>

<style scoped>

</style>
