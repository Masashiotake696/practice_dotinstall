package practice.app.model;

interface Printable {
    // 定数(pubilc static finalは省略できる)
    double VERSION = 1.2;
    // 抽象メソッド(public abstractは省略できる)
    void print();
    // defaultメソッド(抽象メソッドと違い直接実装が書けるメソッド)
    public default void getInfoVersion() {
        System.out.println("I/F ver." + Printable.VERSION);
    }
    // staticメソッド(defaultメソッドが複雑になってきた時に処理をまとめるヘルパー的な用途)
}

public class User implements Printable {
    private String name = "Me!";
    private int score;
    private static int count; 

    // staticプロパティの初期化処理(staticイニシャライザ)
    static {
        // クラス変数の初期化(初期化時に複雑な処理を行う時に使用する)
        User.count = 0;
        System.out.println("Static initializer");
    }

    /*
     * インスタンスを初期化する際に行なう処理をかけるインスタンスイニシャライザがある。
     * コンストラクタとの違いは、インスタンスイニシャライザはインスタンス化される前、今ストラクはインスタンス化された後に実行される。
     * コンストラクタがオーバーロードされていて複数あった場合に共通処理をインスタンスイニシャライザに記述する
     */
    {
        System.out.println("Instance initializer");
    }

    // コンストラクタ
    public User(String name, int score) {
        this.name = name;
        this.score = score;
        // staticプロパティにアクセスするにはクラス名を使用する
        User.count++;
        System.out.println("Constractor");
    } 

    // コンストラクタもメソッドなので、オーバーロードできる
    public User() {
        // User(String name)のコンストラクタがthis()で呼び出される
        this("me", 100); 
    }

    @Override
    public void print() {
        System.out.println("適当");
    }

    public void sayHi() {
        System.out.println("Hi!!!" + this.name);
    }

    // getter
    public String getName() {
        return this.name;
    }

    // getter
    public int getScore() {
        return this.score;
    }

    // setter
    public void setName(String name) {
        this.name = name;
    }

    // setter
    public void setScore(int score) {
        if(score > 0) {
            this.score = score;
        }
    }

    // static method
    public static void getInfo() {
        System.out.println("# of instances: " + User.count);
    }
} 
