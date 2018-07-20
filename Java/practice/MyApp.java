class User {
    String name = "Me!";

    User(String name) {
        this.name = name;
    } 

    // コンストラクタもメソッドなので、オーバーロードできる
    User() {
        // this.name = "me~~~~~";
        // this()はこのクラスのコンストラクタの意味
        this("me====="); // User(String name)のコンストラクタがthis()で呼び出される
    }

    void sayHi() {
        System.out.println("Hi!!!" + this.name);
    }
} 

class AdminUser extends User {
    AdminUser(String name) {
        super(name); // 親クラスのコンストラクタはsuper()で呼び出す。引数がなければ省略することも可能
    }

    void sayHello() {
        System.out.println("Hello" + this.name);
    }

    // オーバーライド(アノテーションを付けることでメソッド名の間違いや引数の間違い時にエラーを出してくれる
    @override
    void sayHi() {
        System.out.println("[admin] Hi!" + this.name);
    }
}


public class MyApp {
    public static void main(String[] args) {
        /* 型
        // 文字(文字はシングルクオートで囲う)
        char a = 'a';
        // 整数 byte short int long(最後にLを付ける)
        int x = 10;
        long y = 55555555555L;
        // 浮動小数点数 float(最後にFをつける) double
        double b = 2345.23;
        float f = 32.33F;
        // 論理値(true or false)
        boolean flag = true;

        String message = "Hello, World";
        System.out.println(message);

        */

        /* 演算 
        + - * / %
        // ++ --
        int i;
        i = 10 / 3;
        System.out.println(i); // 3
        i = 10 % 3;
        System.out.println(i); // 1
        int z = 5;
        z++;
        System.out.println(z); // 6
        z--;
        System.out.println(z); // 5

        double dd = 2525.33;
        int ii = (int)dd;
        System.out.println(ii);

        int iii = 10;
        double ddd = (double)iii / 4;
        System.out.println(ddd);
        */

        /* 配列
        int[] sales; // int型配列を定義
        sales = new int[3]; // 領域を3つ確保する
        sales[0] = 100;
        sales[1] = 200;
        sales[2] = 300;
        System.out.println(sales[0]);
        sales[0] = 1000;
        System.out.println(sales[0]);

        // 宣言と初期化を分ける
        int[] test;
        test = new int[] {100, 200, 300};
        int[] test2 = {100, 200, 300};

        for (int i = 0; i < 3; i++) {
            System.out.println(test[i]);
        }

        for (int i = 0; i < test.length; i++) {
            System.out.println(test[i]);
        }

        for (int sale : sales) {
            System.out.println(sale);
        }
        */

        /* 基本型と参照型
        int x = 10;
        int y = x;
        y = 5;
        System.out.println(x);
        System.out.println(y);

        int[] a = {3,4,5};
        int[] b = a;
        b[1] = 8;
        System.out.println(a[1]);
        System.out.println(b[1]);

        // String型は参照型であるが、限りなく基本データ型と似たような動作になる
        // 基本的に文字列は変更が不可になっていて、違う文字列を割り当てると別の領域に新しくデータを確保する仕組みになっている
        String s  = "hello";
        String t = s;
        System.out.println(t);
        t = "World";
        System.out.println(s);
        System.out.println(t);
        */

        /* メソッド
        sayHi();
        sayHi();
        sayHi();

        saySomeone("Tom");
        saySomeone("Bob");

        String message = getHi();
        System.out.println(message);
        String message2 = getHi("Tom");
        System.out.println(message2);
        */

        // クラス
        User tom;
        tom = new User("Tom");
        System.out.println(tom.name);
        tom.sayHi();
        
        User me = new User();
        System.out.println(me.name);

        AdminUser bob = new AdminUser("Bob");
        System.out.println(bob.name);
        bob.sayHi();
        bob.sayHello();
    }
    
    // メソッド
    public static void sayHi() {
        System.out.println("Hi!");
    }

    public static void saySomeone(String name) {
        System.out.println("Hi!" + name);
    }

    public static String getHi() {
        return "Hi!!!";
    }

    // オーバーロード
    public static String getHi(String name) {
        return "Hi!!!" + name;
    }
}
