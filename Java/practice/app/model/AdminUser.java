package practice.app.model;

// final修飾子はクラス/メソッド/フィールドに使うことができて、これを使用すると変更ができなくなる。つまり、クラスの継承やメソッドのオーバーライドができなくなる。
public final class AdminUser extends User {
    // finalをつけると定数になる。定数の場合はクラス変数(static)とする
    private static final double VERSION = 1.1;

    public AdminUser(String name, int score) {
        super(name, score); // 親クラスのコンストラクタはsuper()で呼び出す。引数がなければ省略することも可能
    }

    public void sayHello() {
        System.out.println("Hello" + this.getName());
    }

    // オーバーライド(アノテーションを付けることでメソッド名の間違いや引数の間違い時にエラーを出してくれる
    @Override
    public final void sayHi() {
        System.out.println("[admin] Hi!" + this.getName());
    }
}
