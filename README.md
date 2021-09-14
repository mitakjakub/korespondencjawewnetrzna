# Korespondencja wewnętrzna
## Książka korespondencji dla instytucji
### Po co?
Projekt na potrzeby pewnej instytucji, którego celem było stworzenie aplikacji, do której wpisywane byłyby informacje o napływającej i wychodzącej, korespondencja nadsyłanej na papierze - czyli aplikacja to po prostu spis, dziennik, książka nadawcza, korespondencja wewnętrzna, czy jak tam zwał. Dla proktologokuratora, swądu, dziadostwa i podobnych kreatur. Aplikacja ma możliwość generowania wydruków z listy korespondencji do ręcznego podpisu przez odbiorców, śledzenie zmian w dodanych wpisach, jakieś powielanie ostatnich rekordów oraz dodatkowo, dołączenie w postaci załączników zeskanowanych dokumentów.
### Na czym?

PHP5, mysql/mariadb.

Tak :)

Posiada co najwyzej wartość historyczną, raczej nieużywalne w dzisiejszych czasach, ale ze wzgledu na własne potrzeby zostało przywrócone do życia w oparciu o k3s.
Uwaga co do aplikacji/kodu - nie potrafię pisać kodu, więc nie wiem, czy to jest:

- **bezpieczne**

- **bezbłędne**

- **poprawne**


## Jak odpalić?
Założenie jest takie, że trzeba się napracować :)

W telegraficznym skrócie - **my way or the highway**:

- dodanie ns do k*s
- zbudowanie Dockerfile jako kw_php
- export obrazu docker kw_php do tar
- wysłanie tar do node k*s
- dodanie tar do ??docker/ctr/k3s ctr?
- załadowanie yamli do k*s
- dodanie schematu do bazy na podzie mariadb
- korzystanie i cieszenie się wspaniałym wyglądem i designem rodem z dalekiej prowincji

## Uwagi
Wiele uwag - nie ma howto - trzeba przejrzeć kod, popatrzeć, czy gdzieś o czymś nie zapomniałem i nie leży na sztywno zaszyta nazwa hosta - na wszelki wypadek podpowiem - użyłem na własne potrzeby nazwy kw.local - tak też prowadzi ingress.

Dwa typy użytkowników - admin może więcej.

Tworzenie komórek organizacyjnych - gdzieś było, ale ta wersja jej nie ma z jakiegoś powodu, więc trzeba popracować rękoma w bazie.

Kolejna uwaga - to jest staroć, jak wcześniej napisałem, nigdy nie programowałem, uznałem to za jakieś tam wyzwanie i chęć napisania czegoś swojego - więc nie ma to może w wielu miejscach sensu, jest rozdmuchane, powiela kod wielokrotnie itp, jest paskudne, niegodne życia i wymaga wbicia osinowego kołka w serce. 

Może.

Nieistotne. 

To jest kompletnie niewspierane, nieużywalne, jeśli to zabierasz, to na własną odpowiedzialność. Jeśli gdzieś tego użyjesz, to miej w opiece ludzi, którzy z tego korzystają, bo nikt inny im nie pomoże :)

Ostatnia uwaga - dodawane z poziomu aplikacji pliki są trzymane w bazie, nie na storage...


### Licencja

Bardzo poważna licencja v2.
Na poważnie, chodzi o czyjąś własność intelektualną, z których korzysta to rozwiązanie.

Trochę czasu upłynęło od rozpoczęcia prac nad tym programem do dnia udostępnienia i niewykluczam, że pewne informacje o prawach i ich właścicielach mogły zostać gdzieś zaprzepaszczone. 
Bardzo za to przepraszam i jeśli tylko uda mi się znaleźć takowe braki, to postaram się je uzupełnić. 

Pewne jest to, ze rozwiązanie korzysta z ogólnie dostępnych rozwiązań, a te o których wiem to:

- jquery: https://jquery.org/license/

- grafika:

    - tła: https://www.toptal.com/designers/subtlepatterns/

    - ikony: https://fonts.google.com/icons