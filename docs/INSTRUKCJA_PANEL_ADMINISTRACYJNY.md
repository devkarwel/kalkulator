# Instrukcja obsługi Panelu Administracyjnego

## Spis treści
1. [Logowanie do panelu](#1-logowanie-do-panelu)
2. [Nawigacja w panelu](#2-nawigacja-w-panelu)
3. [Zarządzanie produktami](#3-zarządzanie-produktami)
4. [Atrybuty produktów](#4-atrybuty-produktów)
5. [Zależności atrybutów](#5-zależności-atrybutów)
6. [Cenniki](#6-cenniki)
7. [Dopłaty](#7-dopłaty)
8. [Kolekcje produktów](#8-kolekcje-produktów)
9. [Użytkownicy](#9-użytkownicy)
10. [Historia kalkulacji](#10-historia-kalkulacji)

---

## 1. Logowanie do panelu

1. Otwórz przeglądarkę i wejdź na adres: `twoja-domena.pl/admin`
2. Wprowadź swój adres e-mail i hasło
3. Kliknij przycisk **Zaloguj**

> 💡 **Wskazówka:** Jeśli zapomniałeś hasła, skontaktuj się z administratorem systemu.

---

## 2. Nawigacja w panelu

Po zalogowaniu zobaczysz menu boczne z następującymi sekcjami:

| Ikona | Nazwa | Opis |
|-------|-------|------|
| 📦 | **Produkty** | Zarządzanie produktami (rolety, żaluzje, plisy) |
| 💰 | **Cenniki** | Konfiguracja przedziałów cenowych |
| 🎨 | **Kolekcje** | Zarządzanie kolekcjami tkanin/kolorów |
| 👥 | **Użytkownicy** | Zarządzanie kontami klientów |
| 📊 | **Kalkulacje** | Historia wycen wykonanych przez klientów |

---

## 3. Zarządzanie produktami

### Wyświetlanie listy produktów
1. Kliknij **Produkty** w menu bocznym
2. Zobaczysz listę wszystkich produktów z informacjami:
   - Kolejność wyświetlania
   - Okładka (miniatura)
   - Nazwa produktu
   - Data dodania i ostatniej edycji

### Edycja produktu
1. Na liście produktów kliknij ikonę **ołówka** przy wybranym produkcie
2. Możesz zmienić:
   - **Aktywny** – włącz/wyłącz widoczność produktu dla klientów
   - **Kolejność wyświetlania** – numer określający pozycję na liście
   - **Nazwa produktu** – wyświetlana nazwa
   - **Slug** – adres URL produktu (generowany automatycznie)
   - **Atrybut szerokości/wysokości/ilości** – powiązanie z polami wymiarów
   - **Okładka** – zdjęcie produktu

3. Kliknij **Zapisz** aby zachować zmiany

### Zakładki produktu
Po wejściu w edycję produktu zobaczysz dodatkowe zakładki:
- **Edycja produktu** – podstawowe dane
- **Atrybuty produktu** – konfiguracja pól formularza
- **Zależności atrybutów** – logika wyświetlania pól

---

## 4. Atrybuty produktów

Atrybuty to pola formularza, które klient wypełnia podczas konfiguracji produktu (np. wymiary, rodzaj montażu, kolor).

### Wyświetlanie atrybutów
1. Wejdź w edycję produktu
2. Kliknij zakładkę **Atrybuty produktu**
3. Zobaczysz listę wszystkich atrybutów z informacjami:
   - Krok (numer etapu w formularzu)
   - Nazwa atrybutu
   - Ilość wartości
   - Ilość zależności
   - Typ pola
   - Dopłaty

### Edycja atrybutu
1. Kliknij ikonę **ołówka** przy wybranym atrybucie
2. Możesz zmienić:

#### Ustawienia główne:
| Pole | Opis |
|------|------|
| **Atrybut aktywny** | Włącza/wyłącza widoczność całego atrybutu |
| **Pole wymagane** | Czy klient musi wybrać wartość |
| **Nagłówek sekcji** | Tytuł wyświetlany nad polem |
| **Typ pola** | Rodzaj pola (lista wyboru, pole tekstowe, obrazek, tekst informacyjny, kolekcja) |
| **Wariant** | Styl wyświetlania (ikony, tekst, liczby) |
| **Strona układu** | Lewa lub prawa kolumna formularza |
| **Krok** | Numer etapu w formularzu konfiguracji |
| **Kolejność** | Pozycja w ramach kroku |

#### Konfiguracja wartości atrybutu:
Każda wartość (opcja do wyboru) ma własne ustawienia:

| Pole | Opis |
|------|------|
| **Aktywny** | Włącza/wyłącza widoczność tej opcji |
| **Nazwa identyfikująca** | Wewnętrzna nazwa (używana w kodzie) |
| **Kolejność** | Pozycja na liście opcji |
| **Dodaj tooltip** | Dodatkowa informacja wyświetlana po najechaniu |
| **Grafika** | Obrazek dla opcji (jeśli wariant to ikony) |

#### Dla pól numerycznych (wymiary):
| Pole | Opis |
|------|------|
| **Pole obowiązkowe** | Czy wymiar jest wymagany |
| **Etykieta** | Nazwa pola (np. "Szerokość") |
| **Placeholder** | Tekst podpowiedzi w pustym polu |
| **Wartość domyślna** | Wstępnie wpisana wartość |
| **Tekst wyjaśniający** | Tooltip z instrukcją |
| **Jednostka miary** | cm, mm, szt itp. |
| **Minimalna wartość** | Najmniejsza dozwolona wartość |
| **Maksymalna wartość** | Największa dozwolona wartość |

3. Kliknij **Zapisz** aby zachować zmiany

### Dodawanie nowej wartości do atrybutu
1. W sekcji "Konfiguracja atrybutu" kliknij **Dodaj +**
2. Wypełnij pola dla nowej wartości
3. Kliknij **Zapisz**

---

## 5. Zależności atrybutów

Zależności określają, kiedy dany atrybut lub jego wartości są widoczne. Na przykład: "Pokaż kolory drewniane tylko gdy wybrano żaluzje drewniane".

### Wyświetlanie zależności
1. Wejdź w edycję produktu
2. Kliknij zakładkę **Zależności atrybutów**

### Struktura zależności
Każda zależność składa się z:
- **Warunki** – co musi być spełnione (np. "rodzaj_zaluzji = drewniane")
- **Pokaż atrybut** – który atrybut wyświetlić
- **Pokaż wartości** – które opcje tego atrybutu pokazać

> ⚠️ **Uwaga:** Edycja zależności wymaga znajomości struktury atrybutów. W razie wątpliwości skontaktuj się z programistą.

---

## 6. Cenniki

Cenniki określają ceny produktów w zależności od wymiarów i wybranych opcji.

### Wyświetlanie cenników
1. Kliknij **Cenniki** w menu bocznym
2. Zobaczysz listę cenników z informacjami:
   - Nazwa cennika
   - Przypisany produkt
   - Liczba przedziałów cenowych
   - Status (aktywny/nieaktywny)

### Edycja cennika
1. Kliknij ikonę **ołówka** przy wybranym cenniku
2. W zakładce **Przedziały cenowe** zobaczysz tabelę z cenami

#### Struktura przedziału cenowego:
| Kolumna | Opis |
|---------|------|
| **Szer. od** | Minimalna szerokość w cm |
| **Szer. do** | Maksymalna szerokość w cm |
| **Wys. od** | Minimalna wysokość w cm |
| **Wys. do** | Maksymalna wysokość w cm |
| **Cena** | Cena w PLN dla tego przedziału |

### Dodawanie przedziału cenowego
1. W zakładce **Przedziały cenowe** kliknij **Utwórz**
2. Wprowadź zakresy wymiarów i cenę
3. Kliknij **Utwórz**

### Modyfikatory cennika
Modyfikatory to dodatkowe dopłaty/rabaty stosowane do ceny bazowej.

1. Kliknij zakładkę **Modyfikatory**
2. Każdy modyfikator określa:
   - Atrybut i wartość, która go aktywuje
   - Typ: kwota (+/- zł) lub procent (+/- %)
   - Wartość modyfikacji

---

## 7. Dopłaty

Dopłaty to dodatkowe koszty za wybrane opcje (np. linka stalowa, mocowanie bezinwazyjne).

### Zarządzanie dopłatami z poziomu atrybutu
1. Wejdź w **Produkty** → wybierz produkt → zakładka **Atrybuty produktu**
2. Przy atrybucie kliknij przycisk **Dopłata** (ikona dolara)
3. Otworzy się okno z dwoma sekcjami:

#### Nowa dopłata:
| Pole | Opis |
|------|------|
| **Wartość atrybutu** | Dla której opcji jest dopłata |
| **Typ** | Dodaj (+) lub Odejmij (-) |
| **Rodzaj** | Kwota (zł) lub Procent (%) |
| **Wartość** | Ile dodać/odjąć |
| **Za sztukę** | Czy mnożyć przez ilość zamawianych produktów |

#### Warunki dopłaty:
Możesz określić, kiedy dopłata ma być naliczana:
- **Warunki wymiarów** – zakres szerokości/ilości sztuk
- **Warunki atrybutów** – tylko gdy wybrano określone opcje

#### Istniejące dopłaty:
Lista już zdefiniowanych dopłat z możliwością edycji i usunięcia.

### Przykład dopłaty
**Dopłata za linkę stalową:**
- Wartość atrybutu: "Linka stalowa"
- Typ: Dodaj
- Rodzaj: Kwota
- Wartość: 26 zł
- Za sztukę: ✓ (tak)
- Warunek: Rodzaj żaluzji = Drewniane

---

## 8. Kolekcje produktów

Kolekcje to grupy tkanin/kolorów z własnymi cenami i miniaturami.

### Wyświetlanie kolekcji
1. Kliknij **Kolekcje** w menu bocznym
2. Zobaczysz listę kolekcji z przypisanymi produktami

### Struktura kolekcji
- **Kolekcja** – grupa (np. "Tkaniny standard")
- **Elementy** – pozycje w grupie (np. "Biały", "Szary")
- **Wartości** – warianty kolorystyczne z cenami

### Edycja kolekcji
1. Kliknij ikonę **ołówka** przy kolekcji
2. W zakładce **Elementy** możesz dodawać/edytować pozycje
3. Każdy element może mieć:
   - Nazwę
   - Miniaturę
   - Wartości z cenami

---

## 9. Użytkownicy

### Wyświetlanie użytkowników
1. Kliknij **Użytkownicy** w menu bocznym
2. Zobaczysz listę kont z informacjami:
   - ID klienta
   - Status konta
   - Typ (Admin/Użytkownik)
   - E-mail
   - Firma

### Dodawanie użytkownika
1. Kliknij **Utwórz**
2. Wypełnij formularz:

| Pole | Opis |
|------|------|
| **Konto aktywne** | Czy użytkownik może się logować |
| **ID klienta** | Unikalny identyfikator |
| **E-mail** | Adres do logowania |
| **Hasło** | Minimum 8 znaków |
| **Telefon** | Numer kontaktowy |
| **Typ konta** | Admin lub Użytkownik |
| **Firma** | Nazwa firmy klienta |
| **Adres** | Adres klienta |

3. Kliknij **Utwórz**

### Rabaty użytkownika
1. Wejdź w edycję użytkownika
2. Kliknij zakładkę **Rabaty produktowe**
3. Możesz przypisać rabat dla konkretnego produktu:
   - Wybierz produkt
   - Ustaw typ rabatu (kwota lub procent)
   - Wprowadź wartość rabatu

---

## 10. Historia kalkulacji

### Przeglądanie kalkulacji
1. Kliknij **Kalkulacje** w menu bocznym
2. Zobaczysz listę wszystkich wycen wykonanych przez klientów:
   - Numer kalkulacji
   - Klient
   - Produkt
   - Cena końcowa
   - Data

### Szczegóły kalkulacji
Kliknij wybraną kalkulację aby zobaczyć:
- Wszystkie wybrane opcje
- Wymiary
- Zastosowane dopłaty
- Cenę przed i po rabacie

---

## Najczęstsze pytania (FAQ)

### Jak wyłączyć opcję z listy wyboru?
1. Wejdź w edycję atrybutu
2. Znajdź wartość w sekcji "Konfiguracja atrybutu"
3. Wyłącz przełącznik **Aktywny**
4. Zapisz zmiany

### Jak zmienić cenę dla przedziału wymiarów?
1. Wejdź w **Cenniki** → wybierz cennik
2. Kliknij zakładkę **Przedziały cenowe**
3. Kliknij ołówek przy wybranym przedziale
4. Zmień cenę i zapisz

### Jak dodać nową dopłatę?
1. **Produkty** → wybierz produkt → **Atrybuty produktu**
2. Przy atrybucie kliknij **Dopłata**
3. W sekcji "Nowa dopłata" wybierz wartość i wprowadź kwotę
4. Opcjonalnie dodaj warunki
5. Kliknij **Zapisz zmiany**

### Jak zmienić kolejność wyświetlania produktów?
1. **Produkty** → edytuj produkt
2. Zmień wartość w polu **Kolejność wyświetlania**
3. Niższy numer = wyżej na liście

### Jak zresetować hasło użytkownika?
1. **Użytkownicy** → edytuj użytkownika
2. W polu **Hasło** wpisz nowe hasło
3. Kliknij **Zapisz**

---

## Pomoc techniczna

W przypadku problemów technicznych lub pytań dotyczących zaawansowanych funkcji, skontaktuj się z administratorem systemu lub zespołem wsparcia.

---

*Dokument wygenerowany: Luty 2026*
