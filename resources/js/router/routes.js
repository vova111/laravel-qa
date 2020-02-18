import QuestionsPage from '../components/pages/QuestionsPage';
import QuestionPage from '../components/pages/QuestionPage';
import MyPostsPage from '../components/pages/MyPostsPage';
import NotFoundPage from '../components/pages/NotFoundPage';
import CreateQuestionPage from '../components/pages/CreateQuestionPage';
import EditQuestionPage from '../components/pages/EditQuestionPage';

const routes = [{
  path: '/',
  component: QuestionsPage,
  name: 'home',
}, {
  path: '/questions',
  component: QuestionsPage,
  name: 'questions',
}, {
  path: '/questions/create',
  component: CreateQuestionPage,
  name: 'questions.create',
}, {
  path: '/questions/:id/edit',
  component: EditQuestionPage,
  name: 'questions.edit'
}, {
  path: '/my-posts',
  component: MyPostsPage,
  name: 'my-posts',
  meta: {
    requiresAuth: true,
  },
}, {
  path: '/questions/:slug',
  component: QuestionPage,
  name: 'questions.show',
}, {
  path: '*',
  component: NotFoundPage,
}];

export default routes;
