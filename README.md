<img alt="Logo" src="http://coderslab.pl/svg/logo-coderslab.svg" width="400">

# ScrumLab PHP

## Czym jest ScrumLab?

ScrumLab to projekt, którego celem jest nauczenie Cię pracy w zespole programistów. Symuluje on realne zadania
w projekcie aplikacji webowej. Podczas tego tygodnia będziesz uczestniczyć w codziennych spotkaniach, rozwiązywać 
problemy, robić *code review* i integrować swój kod z kodem kolegów.

## Opis projektu

Pani Maria Iksińska napisała książkę kucharską, która stała się bestsellerem na rynku książek kucharskich w Polsce i zwróciła się do nas z prośba o przygotowanie dla jej czytelników aplikacji do planowania posiłków. Książka Pani Iksińskiej promuje zdrowe odżywianie i podkreśla jak ważną rolę odgrywa w nim planowanie posiłków. Chce zacząć przeprowadzać w całym kraju warsztaty, na których będzie uczyć uczestników planowania posiłków.

Pani Maria chce rozwijać swój biznes, a do zrealizowania swoich celów potrzebuje strony-wizytówki oraz prostej aplikacji do planowania posiłków.

Przed przystąpieniem do pracy przeczytaj poniższe wskazówki

## Jak zacząć?

1. Stwórz [*fork*](https://guides.github.com/activities/forking/) repozytorium.
2. Sklonuj repozytorium na swój komputer. Użyj do tego komendy `git clone adres_repozytorium`
Adres repozytorium możesz znaleźć na stronie repozytorium po naciśnięciu w guzik "Clone or download".
3. Rozwiąż zadania i skomituj zmiany do swojego repozytorium. Użyj do tego komend `git add nazwa_pliku`.
Jeżeli chcesz dodać wszystkie zmienione pliki użyj `git add .` 
Pamiętaj że kropka na końcu jest ważna!
Następnie skommituj zmiany komendą `git commit -m "nazwa_commita"`
4. Wypchnij zmiany do swojego repozytorium na GitHubie.  Użyj do tego komendy `git push origin master`
5. Stwórz [*pull request*](https://help.github.com/articles/creating-a-pull-request) do oryginalnego repozytorium, gdy skończysz wszystkie zadania.


## Widoki

* `app/Resources/views` – katalog z plikami statycznymi; po szczegóły zajrzyj do rozdziału **Konfiguracja projektu**

## Konfiguracja projektu

### Co skonfigurowaliśmy za Ciebie?

- szablony
  - umieszczaj je w katalogu **app/Resources/views**,
- pliki statyczne
  - pliki statyczne (czyli wszystkie pliki, które są serwowane przez aplikację: obrazki, pliki CSS, JS itp.)
  umieszczaj w katalogu **web/assets**
