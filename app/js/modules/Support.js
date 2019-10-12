export default class Support {
  constructor(el) {
    this.el = el;
    this.el.handler = this.el.handler || {};

    console.log(el);
  }
}
