import { __ } from '@wordpress/i18n'
import { AuthorSelector } from '../AuthorSelector'
import { CategorySelector } from '../CategorySelector'
import { EstTimePicker } from '../EstTimePicker'
import { RssUrlControl } from '../RssUrlControl'
import { SaveButton } from '../SaveButton'
import { useSettings } from '../../hooks/useSettings'

export const SettingsPanel = () => {
	const { settings, setSettings, saveSettings } = useSettings()
	const { rssUrl, digestAuthor, digestCategory, estDailyPost } = settings
	return (
		<>
			<RssUrlControl
				url={ rssUrl }
				onChange={ (v) => setSettings({ rssUrl: v }) }
			/>
			<AuthorSelector
				author={ digestAuthor }
				onChange={ (v) => setSettings({ digestAuthor: v }) }
			/>
			<CategorySelector
				cat={ digestCategory }
				onChange={ (v) => setSettings({ digestCategory: v }) }
			/>
			<EstTimePicker
				est={ estDailyPost }
				onChange={ (v) => setSettings({ estDailyPost: v}) }
			/>
			<SaveButton
				onClick={ saveSettings }
			/>
		</>
	)
}
