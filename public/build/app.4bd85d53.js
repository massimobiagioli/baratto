(window.webpackJsonp=window.webpackJsonp||[]).push([["app"],{ng4s:function(e,t,n){"use strict";n.r(t);var r=n("oCYn"),a=function(){var e=this.$createElement;return(this._self._c||e)("router-view")};a._withStripped=!0;var o={},s=n("KHd+"),i=Object(s.a)(o,a,[],!1,null,null,null);i.options.__file="assets/js/components/App.vue";var c=i.exports,u=n("zlta"),l=n.n(u),p=n("jE9Z"),v=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"row"},[n("div",{staticClass:"col s12 m6"},[n("div",{staticClass:"card"},[n("div",{staticClass:"card-content"},[n("span",{staticClass:"card-title"},[e._v("Login")]),e._v(" "),n("div",{staticClass:"row"},[n("form",{staticClass:"col s12"},[n("div",{staticClass:"row"},[n("div",{staticClass:"input-field col s12"},[n("input",{directives:[{name:"model",rawName:"v-model",value:e.email,expression:"email"}],staticClass:"validate",attrs:{id:"email",type:"email"},domProps:{value:e.email},on:{input:function(t){t.target.composing||(e.email=t.target.value)}}}),e._v(" "),n("label",{attrs:{for:"email"}},[e._v("Email")])])]),e._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"input-field col s12"},[n("input",{directives:[{name:"model",rawName:"v-model",value:e.password,expression:"password"}],staticClass:"validate",attrs:{id:"password",type:"password"},domProps:{value:e.password},on:{input:function(t){t.target.composing||(e.password=t.target.value)}}}),e._v(" "),n("label",{attrs:{for:"password"}},[e._v("Password")])])])])])]),e._v(" "),n("div",{staticClass:"card-action"},[n("a",{staticClass:"waves-effect waves-light btn",on:{click:function(t){return e.login()}}},[e._v("login")])])])])])};v._withStripped=!0;n("pNMO"),n("TeQF"),n("QWBl"),n("HRxU"),n("eoL8"),n("5DmW"),n("27RR"),n("tkto"),n("FZtP");var m=n("L2JU");function d(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}function f(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}var w={name:"Login",data:function(){return{email:"",password:""}},methods:function(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?d(Object(n),!0).forEach((function(t){f(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):d(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}({},Object(m.b)("auth",["login"]))},h=Object(s.a)(w,v,[],!1,null,null,null);h.options.__file="assets/js/components/Login.vue";var g=h.exports,b=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"row"},[n("div",{staticClass:"col s12 m6"},[n("div",{staticClass:"card"},[n("div",{staticClass:"card-content"},[n("span",{staticClass:"card-title"},[e._v("Articoli")]),e._v(" "),n("div",{staticClass:"row"},[n("form",{staticClass:"col s12"},[n("ul",{attrs:{id:"example-1"}},e._l(e.articoli,(function(t){return n("li",{key:t},[e._v("\n                "+e._s(t.id)+" - "+e._s(t.nome)+" - "+e._s(t.monete)+"\n                "),n("span",[n("a",{staticClass:"waves-effect waves-light btn",on:{click:function(n){return e.updateArticolo(t.id)}}},[e._v("Modifica")]),e._v(" "),n("a",{staticClass:"waves-effect waves-light btn",on:{click:function(n){return e.deleteArticolo(t.id)}}},[e._v("Elimina")])]),e._v(">\n              ")])})),0),e._v(" "),n("div",[n("span",[e._v("Articolo")]),e._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"input-field col s12"},[n("input",{directives:[{name:"model",rawName:"v-model",value:e.nome,expression:"nome"}],staticClass:"validate",attrs:{id:"nome",type:"text"},domProps:{value:e.nome},on:{input:function(t){t.target.composing||(e.nome=t.target.value)}}}),e._v(" "),n("label",{attrs:{for:"nome"}},[e._v("Nome")])])]),e._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"input-field col s12"},[n("input",{directives:[{name:"model",rawName:"v-model",value:e.monete,expression:"monete"}],staticClass:"validate",attrs:{id:"monete",type:"number"},domProps:{value:e.monete},on:{input:function(t){t.target.composing||(e.monete=t.target.value)}}}),e._v(" "),n("label",{attrs:{for:"monete"}},[e._v("Monete")])])])])])])]),e._v(" "),n("div",{staticClass:"card-action"},[n("a",{staticClass:"waves-effect waves-light btn",on:{click:function(t){return e.listArticoli()}}},[e._v("Elenca")]),e._v(" "),n("a",{staticClass:"waves-effect waves-light btn",on:{click:function(t){return e.insertArticolo()}}},[e._v("Inserisci")])])])])])};b._withStripped=!0;n("07d7"),n("5s+n"),n("ls82");function y(e,t,n,r,a,o,s){try{var i=e[o](s),c=i.value}catch(e){return void n(e)}i.done?t(c):Promise.resolve(c).then(r,a)}function O(e){return function(){var t=this,n=arguments;return new Promise((function(r,a){var o=e.apply(t,n);function s(e){y(o,r,a,s,i,"next",e)}function i(e){y(o,r,a,s,i,"throw",e)}s(void 0)}))}}function _(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}var x=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e)}var t,n,r,a,o,s,i,c,u;return t=e,(n=[{key:"login",value:(u=O(regeneratorRuntime.mark((function e(t,n){var r,a,o;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return r={method:"POST",body:JSON.stringify({email:t,password:n})},e.prev=1,e.next=4,fetch("/api/auth/login",r);case 4:return a=e.sent,e.next=7,a.json();case 7:return o=e.sent,e.abrupt("return",o);case 11:return e.prev=11,e.t0=e.catch(1),console.log(e.t0.message),e.abrupt("return",null);case 15:case"end":return e.stop()}}),e,null,[[1,11]])}))),function(e,t){return u.apply(this,arguments)})},{key:"listArticoli",value:(c=O(regeneratorRuntime.mark((function e(t){var n,r,a,o;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return(n=new Headers).append("X-AUTH-TOKEN",$authToken),r={method:"GET",headers:n},e.prev=3,e.next=6,fetch("/api/admin/articoli",r);case 6:return a=e.sent,e.next=9,a.json();case 9:return o=e.sent,e.abrupt("return",o);case 13:return e.prev=13,e.t0=e.catch(3),console.log(e.t0.message),e.abrupt("return",null);case 17:case"end":return e.stop()}}),e,null,[[3,13]])}))),function(e){return c.apply(this,arguments)})},{key:"getArticolo",value:(i=O(regeneratorRuntime.mark((function e(t,n){var r,a,o,s;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return(r=new Headers).append("X-AUTH-TOKEN",$authToken),a={method:"GET",headers:r},e.prev=3,e.next=6,fetch("/api/admin/articoli/".concat(n),a);case 6:return o=e.sent,e.next=9,o.json();case 9:return s=e.sent,e.abrupt("return",s);case 13:return e.prev=13,e.t0=e.catch(3),console.log(e.t0.message),e.abrupt("return",null);case 17:case"end":return e.stop()}}),e,null,[[3,13]])}))),function(e,t){return i.apply(this,arguments)})},{key:"insertArticolo",value:(s=O(regeneratorRuntime.mark((function e(t,n){var r,a,o,s;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return(r=new Headers).append("X-AUTH-TOKEN",$authToken),a={method:"POST",headers:r,body:JSON.stringify(n)},e.prev=3,e.next=6,fetch("/api/admin/articoli",a);case 6:return o=e.sent,e.next=9,o.json();case 9:return s=e.sent,e.abrupt("return",s);case 13:return e.prev=13,e.t0=e.catch(3),console.log(e.t0.message),e.abrupt("return",null);case 17:case"end":return e.stop()}}),e,null,[[3,13]])}))),function(e,t){return s.apply(this,arguments)})},{key:"updateArticolo",value:(o=O(regeneratorRuntime.mark((function e(t,n,r){var a,o,s,i;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return(a=new Headers).append("X-AUTH-TOKEN",$authToken),o={method:"UPDATE",headers:a,body:JSON.stringify(r)},e.prev=3,e.next=6,fetch("/api/admin/articoli/".concat(n),o);case 6:return s=e.sent,e.next=9,s.json();case 9:return i=e.sent,e.abrupt("return",i);case 13:return e.prev=13,e.t0=e.catch(3),console.log(e.t0.message),e.abrupt("return",null);case 17:case"end":return e.stop()}}),e,null,[[3,13]])}))),function(e,t,n){return o.apply(this,arguments)})},{key:"deleteArticolo",value:(a=O(regeneratorRuntime.mark((function e(t,n){var r,a,o,s;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return(r=new Headers).append("X-AUTH-TOKEN",$authToken),a={method:"DELETE",headers:r},e.prev=3,e.next=6,fetch("/api/admin/articoli/".concat(n),a);case 6:return o=e.sent,e.next=9,o.json();case 9:return s=e.sent,e.abrupt("return",s);case 13:return e.prev=13,e.t0=e.catch(3),console.log(e.t0.message),e.abrupt("return",null);case 17:case"end":return e.stop()}}),e,null,[[3,13]])}))),function(e,t){return a.apply(this,arguments)})}])&&_(t.prototype,n),r&&_(t,r),e}();function k(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}function j(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function A(e,t,n,r,a,o,s){try{var i=e[o](s),c=i.value}catch(e){return void n(e)}i.done?t(c):Promise.resolve(c).then(r,a)}function C(e){return function(){var t=this,n=arguments;return new Promise((function(r,a){var o=e.apply(t,n);function s(e){A(o,r,a,s,i,"next",e)}function i(e){A(o,r,a,s,i,"throw",e)}s(void 0)}))}}var P=new x,T={name:"Admin",data:function(){return{articoli:[],nome:"",monete:0}},mounted:function(){""!=this.accessToken&&this.allowAdmin||this.$routes.push({path:"/login"})},methods:{listArticoli:function(){var e=this;return C(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,P.listArticoli(e.accessToken);case 2:e.articoli=t.sent,console.log(articoli);case 4:case"end":return t.stop()}}),t)})))()},getArticolo:function(e){var t=this;return C(regeneratorRuntime.mark((function n(){var r;return regeneratorRuntime.wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,P.getArticolo(t.accessToken,e);case 2:r=n.sent,console.log(r);case 4:case"end":return n.stop()}}),n)})))()},insertArticolo:function(){var e=this;return C(regeneratorRuntime.mark((function t(){var n;return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return n={nome:e.nome,monete:e.monete},t.next=3,P.insertArticolo(e.accessToken,n);case 3:return t.sent,console.log(n),t.next=7,e.listArticoli();case 7:case"end":return t.stop()}}),t)})))()},updateArticolo:function(e){var t=this;return C(regeneratorRuntime.mark((function n(){var r;return regeneratorRuntime.wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return r={nome:t.nome,monete:t.monete},n.next=3,P.updateArticolo(t.accessToken,e,r);case 3:return n.sent,console.log(r),n.next=7,t.listArticoli();case 7:case"end":return n.stop()}}),n)})))()},deleteArticolo:function(e){var t=this;return C(regeneratorRuntime.mark((function n(){return regeneratorRuntime.wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,P.deleteArticolo(t.accessToken,e);case 2:return console.log("deleted"),n.next=5,t.listArticoli();case 5:case"end":return n.stop()}}),n)})))()}},computed:function(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?k(Object(n),!0).forEach((function(t){j(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):k(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}({},Object(m.c)("counter",{accessToken:function(e){return e.accessToken},allowAdmin:function(e){return e.allowAdmin}}))},R=Object(s.a)(T,b,[],!1,null,null,null);R.options.__file="assets/js/components/Admin.vue";var E=R.exports,N=function(){var e=this.$createElement;return(this._self._c||e)("div",[this._v("User")])};N._withStripped=!0;var S={},H=Object(s.a)(S,N,[],!1,null,null,null);H.options.__file="assets/js/components/User.vue";var D=H.exports;r.default.use(p.a);var U=new p.a({routes:[{path:"/login",name:"Login",component:g},{path:"/admin",name:"Admin",component:E},{path:"/",name:"User",component:D}]});function $(e,t,n,r,a,o,s){try{var i=e[o](s),c=i.value}catch(e){return void n(e)}i.done?t(c):Promise.resolve(c).then(r,a)}var L={namespaced:!0,state:{accessToken:"",allowAdmin:!1},mutations:{login:function(e,t){e.accessToken=t.accessToken,e.allowAdmin=t.allowAdmin}},actions:{login:function(e,t){var n,r=e.commit;return(n=regeneratorRuntime.mark((function e(){var n,a;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return n=new x,e.next=3,n.login(t.email,t.password);case 3:(a=e.sent)&&(r("login",a),U.push({path:"/user"}));case 5:case"end":return e.stop()}}),e)})),function(){var e=this,t=arguments;return new Promise((function(r,a){var o=n.apply(e,t);function s(e){$(o,r,a,s,i,"next",e)}function i(e){$(o,r,a,s,i,"throw",e)}s(void 0)}))})()}}};r.default.use(m.a);var J=new m.a.Store({modules:{auth:L}});new r.default({vuetify:l.a,router:U,store:J,render:function(e){return e(c)}}).$mount("#app")}},[["ng4s","runtime",0]]]);