<?php

namespace PHPUnit\Commands;

use App\Blog\Commands\Arguments;
use App\Blog\Exceptions\ArgumentsException;
use PHPUnit\Framework\TestCase;

class ArgumentsTest extends TestCase
{
    /**
     * @throws \App\Blog\Exceptions\ArgumentsException
     */
    public function testItReturnsArgumentsValueByName(): void
    {
        $arguments = new Arguments([]);
// Описываем тип ожидаемого исключения
        $this->expectException(ArgumentsException::class);
// и его сообщение
        $this->expectExceptionMessage("No such argument: some_key");
// Выполняем действие, приводящее к выбрасыванию исключения
        $arguments->get('some_key');
    }

    public function argumentsProvider(): iterable
    {
        return [
            ['some_string', 'some_string'], // Тестовый набор
// Первое значение будет передано
// в тест первым аргументом,
// второе значение будет передано
// в тест вторым аргументом
            [' some_string', 'some_string'], // Тестовый набор №2
            [' some_string ', 'some_string'],
            [123, '123'],
            [12.3, '12.3'],
        ];
    }

    /**
     * @dataProvider argumentsProvider
     * @throws ArgumentsException
     */
    public function testItConvertsArgumentsToStrings(
        $inputValue,
        $expectedValue
    ): void {
// Подставляем первое значение из тестового набора
        $arguments = new Arguments(['some_key' => $inputValue]);
        $value = $arguments->get('some_key');
// Сверяем со вторым значением из тестового набора
        $this->assertEquals($expectedValue, $value);
    }



}