/*
■特徴
双方向データバインディング。
データバインディングとはdataとUIを結びつけるという意味。
双方向というのはdataを更新すればUIが更新sれて、UIを更新すればdataが更新sれるという意味。
Vue.jsを使えばdataとUIの紐付けだけを意識すれば良い。
■使い方
    ▼データからUI
        Vue.jsでUIに結びつくモデルを作る。UIに結びつくモデルはよくView Modelと呼ばれる。
        Vueインスタンスを作成して、オプションを指定する。
        ♦︎オプション
            el ... どの領域のVueと結びつけるかを指定する。elはelementsの略
            data ... モデルに持たせる値をキーバリューで指定する。
        指定したデータはキーを{{}}で囲いHTMLに書くことで出力できる。
        また、{{}}にはJSの式をそのまま書ける。
    ▼UIからデータ
        inputタグを使ってフォームの値とデータを結びつける。
        inputタグでv-model属性にdataのキーを指定すると、UIの変更がデータに反映される。
        ※v-から始まる特殊な属性をディレクティブと呼ぶ
■ループ処理
    liタグなどで配列に対してループ処理を行いたい場合は、タグにv-for属性を使う。
    v-for="単数形 in 複数形"のように書き、todoを出力することでループ処理を行える。
        例) v-for="todo in todos"
    また、indexを取得することも可能
        例) v-for="(todo, index) in todos"
■イベント処理
    イベントを紐づけるにはv-onというディレクティブを使い、その後にイベント処理(メソッド)を記述する。
        例) v-on:submit="addItem"
    v-onは良く使うので@で書くこともできる。
        例) @submit="addItem"
    イベント処理(メソッド)はmethodsというキーで書く。
        例) addItem: function() {
                this.todos.push(this.newItem);
            }
            ※data内のデータにはthisでアクセスすることができる。
    formを使っている場合はformがsubmitされて画面が遷移してしまうためうまくいかない。
    そこで、functionの引数にeを指定して、e.preventDefault();を実行することで、規定のページ遷移を無効化することができる。
    しかし、こういった処理は良く行われるため、HTMLで@sumibt.preventとすることで実現することもできる。
■checkboxのチェック
v-modelに対してtrueやfalseを紐付けると、trueの時にチェックをつけてくれる
■データに応じたクラスの付け替え
データに応じてクラスを付け替えるには、v-bind:classというディレクティブを使う。
    例) v-bind:class="{クラス名: bool値}"
    こうすることで、bool値がtrueの時に指定したクラスを適応してくれる。
また、v-bindは良く使われるため、「v-bind:class」の代わりに「:class」と書くこともできる。
■条件処理
    ▼v-showディレクティブ
        <tag v-show="bool値"></tag>とすると、bool値がtrueの時にだけタグの中身が実行される。
    ▼v-ifディレクティブ
        <tag v-if="bool値"></tag>
        <tag v-else></tag>
        ※v-ifよりも先にv-forが実行されるため、v-ifとv-forは同じタグに書かないようにする
■算出プロパティ
    computedというキーを使うことで、データから動的にプロパティを計算してくれる。
■データの永続化
    LocalStorageを使うことで、データを永続化できる。
        例) localStorage.setItem('キー', JSON.stringify(this.キー));
    データの保存は値に何らかの変更が加えられた時に行えばよいが、watchという仕組みを使うことで指定したデータの変更を監視することができる。
        例) watch: {
                キー: function() {
                    キーに変更があった時の処理
                }
            }
    しかし、watchはキーが配列であった場合、配列自体に変更があった時には処理を実行するが、配列の中身の要素の変更までは監視してくれない。
    そこで、データの中身も含めて監視をする場合には、deep watcherという仕組みを使う。
        例) watch: {
                キー: {
                    handler: function() {
                        キーに変更があった時の処理
                    },
                    deep: true
                }
            }
        ※deep watcherはwatchの仕組みにdeepオプションtrueとすることで実現する
    データの保存はDevToolで確認できる。データは保存できているが、読み出しができていないことがわかる。
    Vue.jsのインスタンスにはライフサイクルが定義されているので、アプリがページにマウントされるタイミングでデータを読み込む。
    データの読み込みはlocalStorageを使う。
        例) localStorage.getItem('キー');
    マウントされるタイミングはmountedとして、その時の処理を関数に書く。
■JSメソッド
    ▼JSON.parse
        JSON文字列を解析して、JavaScriptのオブジェクトに変換する。
    ▼JSON.stringify
        JavaScriptオブジェクトをJSON文字列に変換する。
*/
(function() {
    'use strict';

    var vm = new Vue({
        el: '#app',
        data: {
            // name: 'taguchi'
            newItem: '',
            // todos: [{
            //     title: 'task 1',
            //     isDone: false
            // },{
            //     title: 'task 2',
            //     isDone: false
            // }, {
            //     title: 'task 3',
            //     isDone: true
            // }]
            todos: []
        },
        watch: {
            // todos: function() {
            //     localStorage.setItem('todos', JSON.stringify(this.todos));
            // }
            todos: {
                handler: function() {
                    localStorage.setItem('todos', JSON.stringify(this.todos));
                },
                deep: true
            }
        },
        mounted: function() {
            this.todos = JSON.parse(localStorage.getItem('todos')) || [];
        },
        methods: {
            addItem: function(e) {
                var item = {
                    title: this.newItem,
                    isDone: false
                }
                // e.preventDefault();
                this.todos.push(item);
                this.newItem = '';
            },
            deleteItem: function(index) {
                if(confirm('Are you sure?')) {
                    this.todos.splice(index, 1);
                }
            },
            purge: function() {
                if(!confirm('delete finished?')) {
                    return;
                }
                // this.todos = this.todos.filter(function (todo) {
                //     return !todo.isDone;
                // });
                this.todos = this.remaining;
            }
        },
        computed: {
            remaining: function() {
                return this.todos.filter(function (todo) {
                    return !todo.isDone;
                });
            }
        }
    });
})();