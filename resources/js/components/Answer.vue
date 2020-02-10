<template>
  <div class="media post">
    <vote :model="answer" name="answer"></vote>
    <div class="media-body">
      <form v-if="editing">
        <div class="form-group">
          <textarea rows="10" v-model="body" class="form-control"></textarea>
        </div>
        <button type="button" @click="update" :disabled="isInvalid" class="btn btn-primary">Update</button>
        <button type="button" @click="cancel" class="btn btn-outline-secondary">Cancel</button>
      </form>
      <div v-else>
        <div v-html="bodyHtml"></div>
        <div class="row">
          <div class="col-4">
            <div class="ml-auto">
              <a v-if="authorize('modify', answer)" @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
              <button v-if="authorize('modify', answer)" type="button" @click="destroy" class="btn btn-sm btn-outline-danger">
                Delete
              </button>
            </div>
          </div>
          <div class="col-4"></div>
          <div class="col-4">
            <user-info :model="answer" label="Answered"></user-info>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Vote from './Vote';
  import UserInfo from './UserInfo';
  import modification from '../mixins/modification';

  export default {
    components: {
      Vote,
      UserInfo,
    },
    mixins: [modification],
    props: ['answer'],
    data () {
      return {
        body: this.answer.body,
        bodyHtml: this.answer.body_html,
        id: this.answer.id,
        questionId: this.answer.question_id,
        beforeEditCache: null,
      };
    },
    methods: {
      setEditCache () {
        this.beforeEditCache = this.body;
      },
      restoreFromCache () {
        this.body = this.beforeEditCache;
      },
      payload () {
        return {
          body: this.body,
        };
      },
      delete () {
        axios.delete(this.endpoint)
          .then(res => {
            this.$toast.success(res.data.message, "Success", { timeout: 2000 });
            this.$emit('deleted');
          });
      },
    },
    computed: {
      isInvalid () {
        return this.body.length < 10;
      },
      endpoint () {
         return `/questions/${this.questionId}/answers/${this.id}`;
      },
    },
  };
</script>
