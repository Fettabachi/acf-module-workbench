const destination = 'https://acf-module-workbench.timfetter.com/';

export default {
  fetch() {
    return Response.redirect(destination, 301);
  },
};
