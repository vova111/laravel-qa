<template>
  <div class="d-flex flex-column vote-controls">
    <a @click.prevent="voteUp" :title="title('up')" class="vote-up" :class="classes">
      <i class="fa fa-caret-up fa-3x"></i>
    </a>

    <span class="votes-count">{{ count }}</span>

    <a @click.prevent="voteDown" :title="title('down')" class="vote-down" :class="classes">
      <i class="fa fa-caret-down fa-3x"></i>
    </a>

    <favorite v-if="name === 'question'" :question="model"></favorite>
    <accept v-else :answer="model"></accept>
  </div>
</template>

<script>
  import Favorite from './Favorite';
  import Accept from './Accept';

  export default {
    components: {
      Favorite,
      Accept,
    },
    props: ['name', 'model'],
    data () {
      return {
        count: this.model.votes_count || 0,
        id: this.model.id,
      };
    },
    computed: {
      classes () {
        return this.singedIn ? '' : 'off';
      },
      endpoint () {
        return `/${this.name}s/${this.id}/vote`;
      },
    },
    methods: {
      title (voteType) {
        const titles = {
          up: `This ${this.name} is useful`,
          down: `This ${this.name} is useful`,
        };

        return titles[voteType];
      },
      _vote (vote) {
        if (!this.singedIn) {
          this.$toast.warning(`Please login to vote the ${this.name}`, "Warning", {
            timeout: 3000,
            position: 'bottomLeft',
          });

          return;
        }

        axios.post(this.endpoint, { vote })
          .then(res => {
            this.$toast.success(res.data.message, "Success", { timeout: 3000, position: 'bottomLeft' });
            this.count = res.data.votesCount;
          });
      },
      voteUp () {
        this._vote(1);
      },
      voteDown () {
        this._vote(-1);
      },
    },
  };
</script>

<style scoped>

</style>
