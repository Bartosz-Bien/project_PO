<?php

    function zwroc_id_klienta()
    {
        // tu jest zapytanie w bazie danych, ktore zwroci id klienta, potem w pliku .php obok tworzy sie obiekt klasy 'klient_ind/firma' o tych polach, co ma ten rekord w bazie
        return $id;
    }

    class Klient // po kliencie dziedzicza klasy 'firma' i 'klient indywidulany'
    {
        protected $adres;

        public function zaplac() // do implementacji w czesci pracownika - pracownik anuluje dlug, ale klasa klient
        {
            echo 'zaplac';
            // uzytkownik podchodzi do pracownika i pyta czy moze zaplacic dlug wzgledem sklepu
            // 1. program sprawdza w bazie dlug uzytkownika (ale tylko firma moze placic po czasie) o tym nip/adresie/etc i wyswietla
            // 2. pracownik wprowadza splacona kwote
            // 3. program odejmuje od dlugu (zmienna w metodzie) kwote i aktualizuje rekord w tabeli 'klienci' o tym id
            // 4. koniec - klient odchodzi
        }

        public function czy_w_bazie() // czy jest sens tej metody? moze lista rozwijalna, wyszukiwarka sql %like%, etc
        {

        }

        public function skompletuj_zamowienie() // raczej w czesci klienta - klient podchodzi i z listy wybiera co chce i dodaje do koszyka jakby, potem przy kasie odbiera lub korzysta z wyszukiwarki obiektow na sklepie
        {

        }

       // public function przejrzyj_wszytskie_towary() // przeniesienie metody do klasy 'towar', ale wywolana w czesci klienta
       // {
       //
       // }

        public function otrzymanie_dokumentu_potwierdzajacego() // w czesci pracownika, na kasie, ale klasa klient
        {

        }



    }


?>