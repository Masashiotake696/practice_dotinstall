/*
■Component
    ▼概要
    Componentは部品を再利用するための仕組み。
    独自のタグを書くことができて(文字列は何でも良い)、そこに今まで見てきたような機能を実装していくことができる。
    componentの登録はcomponentsオプションをインスタンスに指定する。
        例) components: {
                'コンポーネント名': オブジェクト名
            }
    ▼コンポーネントの作り方
        コンポーネントを変数として定義して、Vue.extendを代入する。
        Vue.extendにどの中身を入れたいかはtemplateで書く。
            例) var コンポーネント名 = Vue.extend({
                    template: テンプレート
                })
            ※テンプレートにかける要素は一つのみで、複数の要素を含めたい場合は、何らかの親要素で囲む必要がある
    ▼コンポーネントのメソッド
        コンポーネントインスタンスの中身にオプションとして買いていく。
    ▼コンポーネントのdata
        コンポーネントのdataは関数で返してあげなくてはならないというルールがある。
    ▼カスタム属性を使う
        コンポーネントの大体の機能は同じだが、少しずつだけ変えたい時には、コンポーネントにカスタム属性として値を渡してそれを使う。
            例) <componentタグ カスタム属性=値></componentタグ>
        カスタム属性をコンポーネントで受け取るにはpropsというキーを使う。propsで受け取る値は配列。
        ♦︎propsにデフォルト値や型を指定
            propsにデフォルト値や型を指定するには配列ではなくオブジェクト形式でpropsを記述する。
            型はtype,デフォルト値はdefaultで指定する。
    ▼コンポーネントから親要素に対してデータを渡す
        いろいろな方法があるが、コンポーネントからイベントを発火して親要素でそれを検出するという手法が一般的。
        イベントの発火には$emitという命令を使う。
            例) this.$emit('increment')
*/
(function() {
    'use strict';

    var likeComponent = Vue.extend({
        // props: ['message'],
        props: {
            message: {
                type: String,
                default: 'Like'
            }
        },
        data: function() {
            return {
                count: 0
            }
        },
        template: '<button @click="countUp">{{ message }} {{ count }}</button>',
        methods: {
            countUp: function() {
                this.count++;
                this.$emit('increment');
            }
        }
    })

    var app = new Vue({
        el: '#app',
        components: {
            'like-component': likeComponent
        },
        data: {
            total: 0
        },
        methods: {
            incrementTotal: function() {
                this.total++;
            }
        }
    });
})();