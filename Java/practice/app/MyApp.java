package practice.app;
import practice.app.model.User;
import practice.app.model.AdminUser;
// ワイルドカードも使える
// import app.model.*;
import java.util.*;

/*
 * 列挙型
 * クラスのように自分で作ることができるデータ型で、定数をまとめたもの
 */
enum Result {
    SUCCESS, // 0
    ERROR, // 1
}

// 例外処理
class MyException extends Exception {
    // コンストラクタでエラーメッセージを受け取る
    public MyException(String str) {
        super(str);
    }
}

/*
 * ラッパークラス
 *
 * 基本データ型に対応する参照型のクラスが用意されている(ラッパークラス)
 * int -> Integer
 * double -> Double
 * Javaのクラスによっては参照型の引数しか受け付けないものもあるので、ラッパークラスと基本データ型を相互に変換できるようにしておく
 */

// generics
class MyData<T> {
    public void getThree(T x) {
        System.out.println(x);
        System.out.println(x);
        System.out.println(x);
    }
}

// スレッド
class MyRunnable implements Runnable { 
    /*
     * 抽象メソッドを一つだけ持つインターフェースは入力に対して出力が一つに定まる
     * こういったインターフェースを関数型インターフェースと呼ぶ。
     * Java8から関数型インターフェースはラムダ式という特殊な記法で置き換えることができる
     * ラムダ式は以下のように書く
     *    (引数) -> {処理}
     */
    @Override
    public void run() {
        for(int i = 0; i < 500; i++) {
            System.out.println('*');
        }
    }
}

public class MyApp {
    // main()はJavaの仮想マシンがインスタンスを作らずにいきなり実行できるようにstaticになっている
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

        // クラス(プロパティ,メソッド,継承)
        /*
        User tom;
        tom = new User("Tom");
        System.out.println(tom.getName());
        
        User me = new User();
        System.out.println(me.getName());

        AdminUser bob = new AdminUser("Bob");
        System.out.println(bob.getName());
        bob.sayHi();
        bob.sayHello();
        */

        /* staticイニシャライザ, インスタンスイニシャライザ
        User.getInfo(); // 0
        User tom = new User("tom", 65);
        User.getInfo(); // 1
        tom.setScore(85);
        tom.setScore(-10);
        System.out.println(tom.getScore());
        User tom2 = new User("tom2", 65);
        User.getInfo(); // 2
        */

        /* 抽象クラス, 抽象メソッド
        User tom = new User();
        tom.print();
        tom.getInfoVersion();
        */

        /* Enum(列挙型)
        Result res;
        res = Result.ERROR;
        switch(res) {
            case SUCCESS:
                System.out.println("OK!");
                System.out.println(res.ordinal()); // 0
                break;
            case ERROR:
                System.out.println("NG");
                System.out.println(res.ordinal()); // 1
                break;
        }
        */

        /* 例外処理
        div(3, 0);    
        div(5, -1);
        */

        // ラッパークラス
        /* 明示的に変換を記述 */
        // 基本データ型 -> ラッパークラス
        // Integer i = new Integer(32);
        // ラッパークラス -> 基本データ型
        // int n = i.intValue();
        /* 良しなにやってくれたりする */
        // Integer j = 32; // auto boxing
        // int m = j; // auto unboxing

        /*
         * generics
         * 汎用化されたデータ型でクラスやインターフェースを作ることができる(引数の型の汎用化など)
         */
        /*
        MyData<Integer> i = new MyData<>(); // <>の中の方は参照型しか使えない
        i.getThree(32);
        MyData<String> s = new MyData<>(); // <>の中の方は参照型しか使えない
        s.getThree("Hello");
        */

        /*
         * スレッド
         * スレッドはコンピュータの処理単位。複数立ち上げることで複数の処理を同時に実行できる(処理は同時に走ることに注意)。
         *
         * スレッドの実装方法
         * 1. Runnableインターフェースを実装したクラスをインスタンス化
         * 2. スレッドクラスインスタンスを1で生成した値を引数に生成
         * 3. スレッドクラスインスタンスに対してstartメソッドを実行する
         */
        /*
        MyRunnable r = new MyRunnable(); // 1
        Thread t = new Thread(r); // 2
        t.start(); // 3
        */
        // 3行をまとめて書くと以下のようになる
        // new Thread(new MyRunnable()).start();
        // 無名クラスを使用して書くと以下のようになる(インターフェースをインスタンス化しているように見えるが、実際はそのインターフェースを実装しているクラスをインスタンス化していることになる)
        /*
        new Thread(new Runnable() {
            @Override
            public void run() {
                for(int i = 0; i < 500; i++) {
                    System.out.println('*');
                }
            }
        }).start();
        */
        // 関数型インターフェースをラムダ式に置き換えると以下のようになる
        /*
        new Thread(() -> {
            for(int i = 0; i < 500; i++) {
                System.out.println('*');
            }
        }).start();
        */
        // for (int i = 0; i < 500; i++) {
        //     System.out.print('.');
        // }

        /*
         * ArrayListクラス
         * ArrayListクラスは配列と違って後から要素を追加したり削除したりできる
         * 使用するにはjava.utilパッケージが必要
         * ArrayListはgenericsを使った型
         *
         * ArrayListと同じくListインターフェースを実装したLinkedListクラスというものもある
         * このクラスはArrayListと同じように使うことができるが、データ構造が異なっており、要素の検索は遅いが追加と削除が早いと言う特徴がある(ArrayListはその逆で、要素の検索は早いが追加と削除が遅い)
         */
        // ArrayList<Integer> sales = new ArrayList<>();
        // ArrayListだけで使えるメソッドはあまり使わないので、ArrayListが実装しているList型インターフェースで宣言することもある(この場合変数の型はインターフェースの型)
        // List<Integer> sales = new ArrayList<>();
        // sales.add(10);
        // sales.add(20);
        // sales.add(30);
        // for(int i = 0; i < sales.size(); i++) {
        //     System.out.println(sales.get(i));
        // }
        // sales.set(0, 100); // 0番目の要素を100に変更
        // sales.remove(2); // 2番目の要素を削除(添字を指定)
        // 以下のようにも書ける
        // for (Integer sale : sales) {
        //     System.out.println(sale);
        // }

        /*
         * HashSet
         * HashSetクラスはArrayListと同様に複数のデータを扱うものだが、重複を許さない点とデータを保持する順番が定まらない点が異なる
         * 使用するにはjava.utilパッケージが必要
         * HashSetはgenericsを使った型
         * 
         * HashSetと似たようなクラスで、TreeSetクラス、LinkedHashSetクラスがある
         * これらは操作は同じだがデータを保持する順番が違う
         * HashSetは順番が不定、TreeSetは値順にソート、LinkedHashSetは追加された順を保持する
         */
        // HashSet<Integer> sales = new HashSet<>();
        // Setインターフェース型で宣言することもできる
        // Set<Integer> sales = new HashSet<>();
        // sales.add(10);
        // sales.add(20);
        // sales.add(30);
        // sales.add(10); // 重複している場合は追加しても要素が増えない
        // 順番が定まらないので、何番目の要素を取り出すといったこともできない
        // System.out.println(sales.size());
        // for(Integer sale : sales) {
        //     System.out.println(sale);
        // }
        // sales.remove(30); // 削除は値を直接指定する 
        // for(Integer sale : sales) {
        //     System.out.println(sale);
        // }

        /*
         * HashMap
         * HashMapクラスはkeyとvalueで複数データを管理するもの
         *
         * HashMapと似たようなクラスにTreeMapとLinkedHashMapがある
         * データの操作については同じだが、データが保持される順番が違う
         * HashMapではデータの順番が不定、TreeMapはKeyの順番でデータを保持、LinkedHashMapではデータが追加された順番でデータを保持
         */
        // keyとvalueの型をgenericsで指定
        // HashMap<String, Integer> sales = new HashMap<>();
        // Mapインターフェース型で宣言することもできる
        // Map<String, Integer> sales = new HashMap<>();
        // sales.put("tom", 10);
        // sales.put("bob", 20);
        // sales.put("steve", 30);
        // System.out.println(sales.get("tom")); // keyで指定
        // System.out.println(sales.size());
        // 全ての中身を確認するにはMap.Entryを使用する
        // for(Map.Entry<String, Integer> sale : sales.entrySet()) {
        //     System.out.println(sale.getKey() + ":" + sale.getValue());
        // }
        // sales.put("tom", 100);
        // sales.remove("steve");
        // for(Map.Entry<String, Integer> sale : sales.entrySet()) {
        //     System.out.println(sale.getKey() + ":" + sale.getValue());
        // }

        /*
         * Stream API
         * 複数の値を順番に処理していく仕組み
         * よくArrayListなどの集合データと合わせて使われる
         */
        // ArrayListに宣言と同時に値を格納するには以下のように書く
        // List<Integer> sales = new ArrayList<>(Arrays.asList(10, 20, 30, 40));
        // Streamを使わない場合
        // for(Integer sale : sales) {
        //     System.out.println(sale);
        // }
        // Streamを使う場合
        // sales
        //     .stream() // データ集合をStreamに変換
            // 中間処理(0個以上)
        //     .filter(e -> e % 3 == 0) // ラムダ式を渡す(引数 -> 処理)
        //     .map(e -> "(" + e + ")")
            // 終端処理
        //     .forEach(System.out::println); // メソッド参照と言う仕組みを使ってメソッド自体を.forEach()に渡す
    }

    public static void div(int a, int b) {
        try {
            if(b < 0) {
                throw new MyException("not minus!");
            }
            System.out.println(a / b);
        } catch(ArithmeticException e) {
            System.err.println(e.getMessage());
        } catch(MyException e) {
            System.err.println(e.getMessage());
        } finally {
            System.out.println(" -- end --");
        }
    }
    
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
